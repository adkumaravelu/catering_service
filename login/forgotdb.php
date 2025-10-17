<?php
session_start();

// DB Connection
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Import PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'send_otp') {
    $email = strtolower(trim($conn->real_escape_string($_POST['email'])));

    // Check if email exists in DB
    $result = $conn->query("SELECT id FROM signup WHERE email = '$email'");
    if ($result && $result->num_rows > 0) {

        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'][$email] = $otp;
        $_SESSION['otp_expire'][$email] = time() + 300; // 5 min expiry

        // Send OTP via PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'kumaraveluad@gmail.com';   // ✅ Your Gmail
            $mail->Password   = 'sxrtjbstvfukqpsu';         // ✅ Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // SSL fix for PHP 5.6
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->setFrom('kumaraveluad@gmail.com', 'Catering Project');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body    = "Your OTP for password reset is: <b>$otp</b>";

            $mail->send();
            echo "otp_sent";
        } catch (Exception $e) {
            echo "failed_to_send: " . $mail->ErrorInfo;
        }
    } else {
        echo "email_not_found";
    }
    exit;
}

if ($action === 'verify_otp') {
    $email = strtolower(trim($conn->real_escape_string($_POST['email'])));
    $otp = $_POST['otp'];

    if (isset($_SESSION['otp'][$email]) && $_SESSION['otp'][$email] == $otp) {
        if (time() <= $_SESSION['otp_expire'][$email]) {
            echo "otp_valid";
        } else {
            echo "otp_expired";
        }
    } else {
        echo "otp_invalid";
    }
    exit;
}

if ($action === 'update_password') {
    $email = strtolower(trim($conn->real_escape_string($_POST['email'])));
    $newPassword = $conn->real_escape_string($_POST['newPassword']);
    // $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    $update = $conn->query("UPDATE signup SET password = '$newPassword' WHERE email = '$email'");
    if ($update) {
        unset($_SESSION['otp'][$email]);
        unset($_SESSION['otp_expire'][$email]);
        echo "updated";
    } else {
        echo "failed";
    }
    exit;
}

echo "invalid_request";
?>