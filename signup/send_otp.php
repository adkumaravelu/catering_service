<?php
session_start();
header('Content-Type: application/json');

// Get form data
$name     = $_POST['name'];
$phone    = $_POST['phone'];
$email    = $_POST['email'];
$password = $_POST['password'];
$role=$_POST['role'];
// Basic validation
if (strlen($name) < 3 || !preg_match('/^\d{10}$/', $phone) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status'=>'error','message'=>'Invalid input']);
    exit;
}

// DB
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    echo json_encode(['status'=>'error','message'=>'DB connection failed']);
    exit;
}

$name     = $conn->real_escape_string($name);
$phone    = $conn->real_escape_string($phone);
$email    = strtolower(trim($conn->real_escape_string($email)));
$password = $conn->real_escape_string($password);
$role =$conn->real_escape_string($role);

$allowedRoles = ['user','agent','admin'];
if (!in_array($role, $allowedRoles)) {
    echo json_encode(['status'=>'error','message'=>'Invalid role. Choose user, agent, or admin.']);
    exit;
}

// Check existing user
$exists = $conn->query("SELECT id FROM signup WHERE email='$email' OR phone='$phone'");
if ($exists && $exists->num_rows > 0) {
    echo json_encode(['status'=>'error','message'=>'User already exists with this phone or email.']);
    exit;
}

// Generate OTP and store in session
$otp = rand(100000, 999999);
$_SESSION['signup_otp'] = $otp;
$_SESSION['signup_data'] = [
    'name' => $name,
    'phone' => $phone,
    'email' => $email,
    'password' => $password, // (plain as requested)
    'role'     => $role 
];

// PHPMailer
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';
require __DIR__ . '/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kumaraveluad@gmail.com';   // <-- replace
    $mail->Password   = 'sxrtjbstvfukqpsu';              // <-- replace (Gmail App Password)
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Optional (older PHP SSL)
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->setFrom('kumaravelu@gmail.com', 'Catering Signup');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your Signup OTP';
    $mail->Body    = "Your OTP is: <strong>$otp</strong>";

    $mail->send();
    echo json_encode(['status'=>'ok','message'=>'OTP sent successfully. Check your inbox/spam.']);
} catch (Exception $e) {
    echo json_encode(['status'=>'error','message'=>'Email failed: '.$mail->ErrorInfo]);
}
