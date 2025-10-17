<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}
$userId = $_SESSION['user_id'];

$conn = new mysqli("localhost","root","","catering");
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

if(isset($_GET['cancel_id'])){
    $cancelId = intval($_GET['cancel_id']);

    // Fetch event
    $stmt = $conn->prepare("SELECT * FROM register WHERE id=? AND user_id=? AND status=0");
    $stmt->bind_param("ii", $cancelId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();

    if($event){
        // Update status
        $stmt = $conn->prepare("UPDATE register SET status=1 WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $cancelId, $userId);
        $stmt->execute();
        $stmt->close();

        // Send email to admin
        $adminEmail = "";
        $subject = "Event Canceled by User";
        $message = "User ID: $userId\nEvent Name: ".$event['event_name']."\nService: ".$event['service_name']."\nDate: ".$event['event_date']."\nStatus: Canceled";
        $headers = "From: no-reply@yourdomain.com";
        mail($adminEmail, $subject, $message, $headers);

        header("Location: carddetails.php?message=Event+Canceled");
        exit;
    } else {
        header("Location: carddetails.php?error=Invalid+Event");
        exit;
    }
} else {
    header("Location: carddetails.php");
    exit;
}
?>
