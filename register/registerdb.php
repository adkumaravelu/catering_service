<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    showAlert("DB Connection Failed", "Unable to connect to database.", "error");
}

// ========== ALERT FUNCTION ==========
function showAlert($title, $text, $icon = 'warning', $redirect = '') {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset='UTF-8'>
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
      <script>
        Swal.fire({
          title: '$title',
          html: '$text',
          icon: '$icon',
          confirmButtonText: 'OK'
        }).then(() => {
          " . (!empty($redirect) ? "window.location.href = '$redirect';" : "window.history.back();") . "
        });
      </script>
    </body>
    </html>
    ";
    exit;
}

// Collect form data
$user_id            = (int)$_POST['user_id'];
$service_name       = $conn->real_escape_string($_POST['Catering_Service']);
$amount             = (int)$_POST['total_amount'];
$event_name         = $conn->real_escape_string($_POST['event_name']);
$event_date         = $conn->real_escape_string($_POST['event_date']);
$morning_persons    = (int)$_POST['morning_persons'];
$afternoon_persons  = (int)$_POST['afternoon_persons'];
$night_persons      = (int)$_POST['night_persons'];
$veg_menu           = $conn->real_escape_string($_POST['veg_menu']);
$nonveg_menu        = $conn->real_escape_string($_POST['nonveg_menu']);
$mixed_menu         = $conn->real_escape_string($_POST['mixed_menu']);
$traveling_distance = (int)$_POST['traveling_distance'];
$service_type       = $conn->real_escape_string($_POST['service_type']);
$catering_service   = (int)$_POST['catering_count'];
$menu_items         = $conn->real_escape_string($_POST['menu_items']);

// Duplicate check
$check_sql = "SELECT * FROM register 
              WHERE user_id='$user_id' 
                AND service_name='$service_name' 
                AND event_date='$event_date'
                AND (morning_persons > 0 OR afternoon_persons > 0 OR night_persons > 0)
              LIMIT 1";
$check_result = $conn->query($check_sql);
if ($check_result && $check_result->num_rows > 0) {
    showAlert("Duplicate Entry", "You have already registered for this service on this date and selected slot(s).", "warning");
    exit;
}

// Insert into DB
$sql = "INSERT INTO register (
            user_id, service_name, amount, event_name, event_date,
            morning_persons, afternoon_persons, night_persons,
            veg_menu, nonveg_menu, mixed_menu, service_type, cating_service,
            traveling_distance, menu_items
        ) VALUES (
            '$user_id', '$service_name', '$amount', '$event_name', '$event_date',
            '$morning_persons', '$afternoon_persons', '$night_persons',
            '$veg_menu', '$nonveg_menu', '$mixed_menu', '$service_type', '$catering_service',
            '$traveling_distance', '$menu_items'
        )";
if (!$conn->query($sql)) {
    showAlert("Database Error", addslashes($conn->error), "error");
}

// Get user email
$email_sql = "SELECT email FROM signup WHERE id='$user_id' LIMIT 1";
$email_result = $conn->query($email_sql);
if (!$email_result || $email_result->num_rows == 0) {
    showAlert("User Error", "Email address not found for this user.", "error");
}
$row = $email_result->fetch_assoc();
$user_email = $row['email'];

// Get agent email (based on service_name match)
$agent_sql = "SELECT agent_email FROM agent_request WHERE agent_name='$service_name' LIMIT 1";
$agent_result = $conn->query($agent_sql);
$agent_email = '';
if ($agent_result && $agent_result->num_rows > 0) {
    $agent_row = $agent_result->fetch_assoc();
    $agent_email = $agent_row['agent_email'];
}

// ==================== EMAIL ====================
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';
require __DIR__ . '/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Common message body
$messageBody = "
    <h3>Catering Event Registration Details</h3>
    <p><strong>Service Name:</strong> $service_name</p>
    <p><strong>Event Name:</strong> $event_name</p>
    <p><strong>Event Date:</strong> $event_date</p>
    <p><strong>Morning Persons:</strong> $morning_persons</p>
    <p><strong>Afternoon Persons:</strong> $afternoon_persons</p>
    <p><strong>Night Persons:</strong> $night_persons</p>
    <p><strong>Veg Menu:</strong> $veg_menu</p>
    <p><strong>Non-Veg Menu:</strong> $nonveg_menu</p>
    <p><strong>Mixed Menu:</strong> $mixed_menu</p>
    <p><strong>Menu Items:</strong> $menu_items</p>
    <p><strong>Service Type:</strong> $service_type</p>
    <p><strong>Catering Service:</strong> $catering_service</p>
    <p><strong>Traveling Distance:</strong> $traveling_distance KM</p>
    <h4>Total Amount: ₹$amount</h4>
";

try {
    // Base mail config
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kumaraveluad@gmail.com';   // your gmail
    $mail->Password   = 'sxrtjbstvfukqpsu';         // gmail app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        ]
    ];
    $mail->setFrom('kumaraveluad@gmail.com', 'Catering Service');
    $mail->isHTML(true);
    $mail->Subject = 'Catering Event Registration Confirmation';
    $mail->Body    = $messageBody;

    // 1️⃣ Send to User
    $mail->clearAddresses();
    $mail->addAddress($user_email);
    $mail->send();

    // 2️⃣ Send to Agent (if available)
    if (!empty($agent_email)) {
        $mail->clearAddresses();
        $mail->addAddress($agent_email);
        $mail->send();
    }

    // ✅ Success message
    $extraMsg = !empty($agent_email) ? " and <b>$agent_email</b>" : "";
    showAlert("Registration Successful!", "Confirmation email sent to <b>$user_email</b>$extraMsg", "success", "../login/login.php");

} catch (Exception $e) {
    showAlert("Email Failed", addslashes($mail->ErrorInfo), "error");
}
?>
