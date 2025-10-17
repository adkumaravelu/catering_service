<?php
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['ids']) && !empty($data['ids'])) {
    // Remove selected rows (set status = 1)
    $ids = $data['ids'];
    $in = implode(',', array_map('intval', $ids));
    $sql = "UPDATE register SET status = 1 WHERE id IN ($in)";
    echo $conn->query($sql) ? "Selected events removed successfully." : "Error: " . $conn->error;
} elseif (isset($data['id'], $data['column'], $data['value'])) {
    // Update single cell
    $id = (int)$data['id'];
    $column = $conn->real_escape_string($data['column']);
    $value = $conn->real_escape_string($data['value']);
    $sql = "UPDATE register SET `$column`='$value' WHERE id=$id";
    echo $conn->query($sql) ? "Cell updated successfully." : "Error: " . $conn->error;
} else {
    echo "Invalid request.";
}

$conn->close();
?>
