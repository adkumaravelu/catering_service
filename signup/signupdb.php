<?php
session_start();
header('Content-Type: application/json');

$enteredOtp = $_POST['otp'];
$sessionOtp = $_SESSION['signup_otp'];
$user       = $_SESSION['signup_data'];

if (!$user || !$sessionOtp) {
    echo json_encode(['status'=>'error','message'=>'Session expired. Please request a new OTP.']);
    exit;
}

if ($enteredOtp != $sessionOtp) {
    echo json_encode(['status'=>'error','message'=>'Invalid OTP.']);
    exit;
}

// DB
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    echo json_encode(['status'=>'error','message'=>'DB connection failed']);
    exit;
}

// Insert
$name = $conn->real_escape_string($user['name']);
$phone = $conn->real_escape_string($user['phone']);
$email = $conn->real_escape_string($user['email']);
$password = $conn->real_escape_string($user['password']); // (plain as requested)
$role =$conn->real_escape_string($user['role']);

$allowedRoles = ['user','agent','admin'];
if (!in_array($role, $allowedRoles)) {
    echo json_encode(['status'=>'error','message'=>'Invalid role.']);
    exit;
}

$sql = "INSERT INTO signup (name, phone, email, password,role)
        VALUES ('$name', '$phone', '$email', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    unset($_SESSION['signup_otp'], $_SESSION['signup_data']);
    echo json_encode(['status'=>'ok','message'=>'Signup success!']);
} else {
    echo json_encode(['status'=>'error','message'=>'Signup failed: '.$conn->error]);
}
