<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}
$userId = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "catering");
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

$sql = "SELECT * FROM addcard WHERE status=0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Catering Services</title>
<style>
.cards { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
.card { width: 250px; background: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden; }
.card img { width: 100%; height: 160px; object-fit: cover; }
.card-body { padding: 15px; }
.card-body h3 { margin: 0 0 10px; }
.stars { color: #FFD700; font-size: 16px; margin-bottom: 8px; }
.amount { color: #4CAF50; font-weight: bold; margin-bottom: 10px; }
.description { font-size: 14px; color: #333; }
.view-events-btn { display:inline-block; margin:10px; padding:10px 15px; background:#2196F3; color:white; text-decoration:none; border-radius:5px; }
.logout-btn {
    position: absolute;
    top: 80px;
    right: 20px;
    padding: 8px 15px;
    background: #f44336;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background 0.3s;
}
.logout-btn:hover {
    background: #d32f2f;
}

</style>
</head>
<body>

<h2 style="text-align:center;">Catering Services</h2>

<a href="cancelevent.php" class="view-events-btn">View / Cancel My Events</a>
<a href="../login/login.php" class="logout-btn">Log out</a>

<div class="cards">
<?php while($row = $result->fetch_assoc()): ?>
<a href="../register/register.php?service=<?php echo urlencode($row['name']); ?>&amount=<?php echo urlencode($row['amount']); ?>" class="card">
    <img src="<?php echo htmlspecialchars($row['img_src']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
    <div class="card-body">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <div class="amount">₹ <?php echo htmlspecialchars($row['amount']); ?></div>
        <div class="stars"><?php echo str_repeat("★", floor($row['rating'])) . str_repeat("☆", 5 - floor($row['rating'])); ?> (<?php echo $row['rating']; ?>)</div>
        <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
    </div>
</a>
<?php endwhile; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
