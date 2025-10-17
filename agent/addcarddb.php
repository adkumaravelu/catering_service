<?php
session_start();

// ---- LOAD PHPMailer (always at top) ----
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';
require __DIR__ . '/PHPMailer/Exception.php';

// ---- DB CONNECTION ----
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// ---- ALERT FUNCTION ----
function showAlert($title, $text, $icon = 'info', $redirect = '') {
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
          confirmButtonColor: '#3085d6',
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

// ---- GET FORM DATA ----
$name        = trim($_POST['name']);
$amount      = $_POST['amount'];
$rating      = $_POST['rating'];
$description = $_POST['description'];
$image       = $_POST['image'];

if (empty($name)) {
    showAlert("Validation Error!", "Catering/Agent name cannot be empty.", "error");
}

// ---- Check duplicate in addcard ----
$check_sql = "SELECT id FROM addcard WHERE name = ? LIMIT 1";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $name);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $check_stmt->close();
    showAlert("Duplicate!", "This catering name already exists.", "error");
}
$check_stmt->close();

// ---- INSERT INTO addcard ----
$sql = "INSERT INTO addcard (name, amount, rating, description, img_src, status)
        VALUES (?, ?, ?, ?, ?, '0')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsss", $name, $amount, $rating, $description, $image);

if ($stmt->execute()) {
    // ---- FIND AGENT EMAIL ----
    $sql2 = "SELECT agent_email 
             FROM agent_request 
             WHERE TRIM(LOWER(agent_name)) = TRIM(LOWER(?)) 
             LIMIT 1";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("s", $name);
    $stmt2->execute();
    $result = $stmt2->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $agentEmail = $row['agent_email'];

        if (empty($agentEmail)) {
            showAlert("Added!", "Service added but agent email is empty in DB.", "warning", "carddetails.php");
        }

        // ---- PHPMailer ----
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = '';   // your gmail
            $mail->Password   = '';         // gmail app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->SMTPOptions = [
                'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
                ]
            ];

            $mail->setFrom('', 'Catering Admin');
            $mail->addAddress($agentEmail);

            $mail->isHTML(true);
            $mail->Subject = "Catering Service Added";
            $mail->Body    = "<p>Hello Agent,</p>
                              <p>Your catering service <b>$name</b> has been successfully added.</p>";

            $mail->send();
            showAlert("Success!", "Service added and email sent to agent ($agentEmail).", "success", "carddetails.php");

        } catch (Exception $e) {
            echo "<pre>";
            echo "Service added successfully, but email sending failed.\n\n";
            echo "PHPMailer Error: " . $mail->ErrorInfo . "\n";
            echo "Exception: " . $e->getMessage() . "\n";
            echo "</pre>";
            exit;
        }

    } else {
        showAlert("Added!", "Service added successfully. No agent found for this agent name.", "info", "carddetails.php");
    }

} else {
    showAlert("Error!", "Database insert failed: " . addslashes($stmt->error), "error");
}

$stmt->close();
$conn->close();
?>
