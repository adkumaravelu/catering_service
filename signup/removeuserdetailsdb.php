<?php
$conn = new mysqli("localhost", "root", "", "catering");
$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['ids'])){
    $ids = $data['ids'];
    $in = implode(',', array_map('intval', $ids));
    $sql = "UPDATE signup SET status = 1 WHERE id IN ($in)";
    if($conn->query($sql)) {
        echo "Selected users removed successfully.";
    } else {
        echo "Error: ".$conn->error;
    }
} else {
    echo "No users selected.";
}

$conn->close();
?>
