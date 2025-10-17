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

// Get today's date
$today = date('Y-m-d');

// Check if search is applied
$searchUserId = isset($_GET['search_user']) ? trim($_GET['search_user']) : "";

// Base SQL
$sql = "SELECT * FROM register WHERE event_date >= ? AND status = 0";

// Add condition if search is provided
if (!empty($searchUserId)) {
    $sql .= " AND user_id = ?";
}

$stmt = $conn->prepare($sql);

// Bind params depending on search
if (!empty($searchUserId)) {
    $stmt->bind_param("ss", $today, $searchUserId);
} else {
    $stmt->bind_param("s", $today);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upcoming Events</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #ddd; }
        .search-box {
            text-align: right;
            margin-bottom: 10px;
        }
        .search-input {
            padding: 6px;
            font-size: 14px;
            width: 200px;
        }
        .search-btn {
            padding: 6px 12px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }
        .search-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Upcoming Catering Events</h2>

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

    <!-- Search Bar -->
    <div class="search-box">
        <form method="get" action="">
            <input type="text" name="search_user" class="search-input" placeholder="Enter User ID" 
                   value="<?php echo htmlspecialchars($searchUserId); ?>">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <div style="width: 100%; max-height: 500px; overflow: auto; border: 1px solid #ccc; padding: 10px;">
        <table style="width: 1500px; min-width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width: 50px; position: sticky; top: 0;">ID</th>
                    <th style="width: 80px; position: sticky; top: 0;">User ID</th>
                    <th style="width: 150px; position: sticky; top: 0;">Service Name</th>
                    <th style="width: 120px; position: sticky; top: 0;">Amount</th>
                    <th style="width: 150px; position: sticky; top: 0;">Event Name</th>
                    <th style="width: 100px; position: sticky; top: 0;">Event Date</th>
                    <th style="width: 120px; position: sticky; top: 0;">Morning Persons</th>
                    <th style="width: 120px; position: sticky; top: 0;">Afternoon Persons</th>
                    <th style="width: 120px; position: sticky; top: 0;">Night Persons</th>
                    <th style="width: 120px; position: sticky; top: 0;">Veg Menu</th>
                    <th style="width: 120px; position: sticky; top: 0;">Non-Veg Menu</th>
                    <th style="width: 120px; position: sticky; top: 0;">Mixed Menu</th>
                    <th style="width: 150px; position: sticky; top: 0;">Menu Items</th>
                    <th style="width: 120px; position: sticky; top: 0;">Service Type</th>
                    <th style="width: 150px; position: sticky; top: 0;">Catering Service Count</th>
                    <th style="width: 150px; position: sticky; top: 0;">Traveling Distance (KM)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                            <td>₹ <?php echo htmlspecialchars($row['amount']); ?></td>
                            <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['morning_persons']); ?></td>
                            <td><?php echo htmlspecialchars($row['afternoon_persons']); ?></td>
                            <td><?php echo htmlspecialchars($row['night_persons']); ?></td>
                            <td><?php echo htmlspecialchars($row['veg_menu']); ?></td>
                            <td><?php echo htmlspecialchars($row['nonveg_menu']); ?></td>
                            <td><?php echo htmlspecialchars($row['mixed_menu']); ?></td>
                            <td><?php echo htmlspecialchars($row['menu_items']); ?></td>
                            <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['cating_service']); ?></td>
                            <td><?php echo htmlspecialchars($row['traveling_distance']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="16">No records found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("table");
    const headers = table.querySelectorAll("th");
    let sortDirection = {};

    headers.forEach((header, index) => {
        header.style.cursor = "pointer"; // Show it's clickable
        header.addEventListener("click", () => {
            const rows = Array.from(table.querySelector("tbody").rows);
            const isNumeric = !isNaN(rows[0].cells[index].innerText.trim().replace(/[₹,]/g, ""));
            
            // Toggle sorting direction
            sortDirection[index] = !sortDirection[index];
            const direction = sortDirection[index] ? 1 : -1;

            rows.sort((a, b) => {
                let aText = a.cells[index].innerText.trim();
                let bText = b.cells[index].innerText.trim();

                if (isNumeric) {
                    aText = parseFloat(aText.replace(/[₹,]/g, "")) || 0;
                    bText = parseFloat(bText.replace(/[₹,]/g, "")) || 0;
                }

                return aText > bText ? direction : aText < bText ? -direction : 0;
            });

            // Re-append sorted rows
            rows.forEach(row => table.querySelector("tbody").appendChild(row));
        });
    });
});
</script>

</html>

<?php
$stmt->close();
$conn->close();
?>
