<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle remove action
if (isset($_POST['remove_id'])) {
    $id = (int)$_POST['remove_id'];
    $update = $conn->prepare("UPDATE addcard SET status = 0 WHERE id = ?");
    $update->bind_param("i", $id);
    $update->execute();
}

// Fetch cards with status 0
$result = $conn->query("SELECT * FROM addcard WHERE status = 1");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Remove Cards</title>
    <style>
        .cards { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .card {
            width: 250px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
        }
        .card img { width: 100%; height: 160px; object-fit: cover; }
        .card-body { padding: 15px; }
        .card-body h3 { margin: 0 0 10px; }
        .stars { color: #FFD700; font-size: 16px; margin-bottom: 8px; }
        .amount { color: #4CAF50; font-weight: bold; margin-bottom: 10px; }
        .description { font-size: 14px; color: #333; }
        .remove-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .remove-btn:hover { background-color: #2d7430ff; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Remove Catering Cards</h2>
     <div style="text-align: left; margin-bottom: 10px;">
        <button onclick="window.location.href='../admin/admin.php'" 
                style="padding: 8px 16px; 
                       background-color: #4CAF50; 
                       color: white; 
                       border: none; 
                       border-radius: 4px; 
                       cursor: pointer;">Back
        </button>
    </div>
    <div class="cards">
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="card">
            <img src="<?php echo htmlspecialchars($row['img_src']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <div class="card-body">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <div class="amount">₹ <?php echo htmlspecialchars($row['amount']); ?></div>
                <div class="stars"><?php echo str_repeat("★", floor($row['rating'])) . str_repeat("☆", 5 - floor($row['rating'])); ?> (<?php echo $row['rating']; ?>)</div>
                <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                
                <form method="post" style="text-align:center;">
                    <input type="hidden" name="remove_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="remove-btn">Activate</button>
                </form>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
