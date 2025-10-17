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

// Fetch user's active registrations
$sql = "SELECT * FROM register 
        WHERE user_id='$userId' 
        AND event_date >= CURDATE() AND status=0
        ORDER BY event_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Registered Events</title>
    <style>
        body{ font-family: Arial; margin: 20px; }
        table{ width: 100%; border-collapse: collapse; }
        th, td{ padding: 10px; border:1px solid #ddd; text-align: center; }
        th{ background-color: #f2f2f2; }
        .cancel-btn{ padding: 5px 10px; background: #f44336; color: white; border-radius: 4px; text-decoration:none; }
        .back-btn {
    display: inline-block;
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 8px 15px;
    background: #2196F3;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    font-size: 14px;
    transition: background 0.3s;
}
.back-btn:hover {
    background: #0b7dda;
}

    </style>
</head>
<body>
<a href="carddetails.php" class="back-btn">Back</a>
<h2>My Registered Events</h2>

<?php
if(isset($_GET['message'])){
    echo "<p style='color:green;'>".htmlspecialchars($_GET['message'])."</p>";
}
if(isset($_GET['error'])){
    echo "<p style='color:red;'>".htmlspecialchars($_GET['error'])."</p>";
}
?>

<?php if($result->num_rows > 0): ?>
<div style="overflow-x:auto; max-height:500px; border:1px solid #ddd; padding:5px;">
<table>
<tr>
    <th>Service Name</th>
    <th>Event Name</th>
    <th>Event Date</th>
    <th>Morning</th>
    <th>Afternoon</th>
    <th>Night</th>
    <th>Veg Menu</th>
    <th>Non-Veg Menu</th>
    <th>Mixed Menu</th>
    <th>Menu Items</th>
    <th>Service Type</th>
    <th>Catering Service</th>
    <th>Traveling Distance</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Action</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['service_name']); ?></td>
    <td><?= htmlspecialchars($row['event_name']); ?></td>
    <td><?= htmlspecialchars($row['event_date']); ?></td>
    <td><?= htmlspecialchars($row['morning_persons']); ?></td>
    <td><?= htmlspecialchars($row['afternoon_persons']); ?></td>
    <td><?= htmlspecialchars($row['night_persons']); ?></td>
    <td><?= htmlspecialchars($row['veg_menu']); ?></td>
    <td><?= htmlspecialchars($row['nonveg_menu']); ?></td>
    <td><?= htmlspecialchars($row['mixed_menu']); ?></td>
    <td><?= htmlspecialchars($row['menu_items']); ?></td>
    <td><?= htmlspecialchars($row['service_type']); ?></td>
    <td><?= htmlspecialchars($row['cating_service']); ?></td>
    <td><?= htmlspecialchars($row['traveling_distance']); ?> KM</td>
    <td>₹ <?= htmlspecialchars($row['amount']); ?></td>
    <td><?= $row['status']==0 ? 'Active' : 'Canceled'; ?></td>
    <td>
        <?php if($row['status']==0): ?>
        <a href="canceleventdb.php?cancel_id=<?= $row['id']; ?>" 
           class="cancel-btn" 
           onclick="return confirm('Are you sure you want to cancel this event?');">Cancel</a>
        <?php else: ?> - <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>
<?php else: ?>
<p>No registered events found.</p>
<?php endif; ?>
<script>
// Simple table sort function
function sortTable(n) {
    let table = document.querySelector("table");
    let rows = Array.from(table.rows).slice(1); // skip header row
    let switching = true;
    let dir = table.getAttribute("data-sort-dir") || "asc";
    let shouldSwitch, x, y, i;

    rows.sort((a, b) => {
        x = a.cells[n].innerText.toLowerCase();
        y = b.cells[n].innerText.toLowerCase();

        // If numeric, compare numbers
        if(!isNaN(x) && !isNaN(y)) {
            x = Number(x);
            y = Number(y);
        }

        if (dir === "asc") {
            return x > y ? 1 : (x < y ? -1 : 0);
        } else {
            return x < y ? 1 : (x > y ? -1 : 0);
        }
    });

    // Toggle direction
    table.setAttribute("data-sort-dir", dir === "asc" ? "desc" : "asc");

    // Reattach rows
    for (i = 0; i < rows.length; i++) {
        table.tBodies[0].appendChild(rows[i]);
    }
}
</script>

</body>
</html>
<?php $conn->close(); ?>
