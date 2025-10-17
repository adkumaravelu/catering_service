<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    echo json_encode(['status'=>'error','message'=>'Database connection failed']);
    exit;
}

$email    = trim($_POST['email']);
$password = trim($_POST['password']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status'=>'error','message'=>'Invalid email format']);
    exit;
}

$stmt = $conn->prepare("SELECT id, name, email, password, role FROM signup WHERE email = ? AND status = 0");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($userId, $name, $dbEmail, $storedPassword, $role);
    $stmt->fetch();
    
    if ($password === $storedPassword) {  // ⚠️ Use password_verify if hashed
        session_start();
        $_SESSION['user_id'] = $userId;
        $_SESSION['email']   = $dbEmail;
        $_SESSION['name']    = $name;
        $_SESSION['role']    = $role;

        // ✅ Redirect based on role
        if ($role === 'admin') {
            $redirect = '../admin/admin.php';
        } elseif ($role === 'user') {
            $redirect = '../agent/carddetails.php';
        } elseif ($role === 'agent') {
            $redirect = '../agent/addagent.php?user_id=' . urlencode($userId) .
                        '&name=' . urlencode($name) .
                        '&email=' . urlencode($dbEmail);
        } else {
            $redirect = '../index.php';
        }

        echo json_encode([
            'status'   => 'success',
            'message'  => '✅ Login successful',
            'redirect' => $redirect
        ]);
    } else {
        echo json_encode(['status'=>'error','message'=>'❌ Incorrect password']);
    }
} else {
    echo json_encode(['status'=>'error','message'=>'❌ Email not found']);
}

$stmt->close();
$conn->close();
?>
