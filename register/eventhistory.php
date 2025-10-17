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

// Fetch all upcoming events
// Fetch all upcoming events with status 0
$stmt = $conn->prepare("SELECT * FROM register");
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
    </style>
</head>
<body>
    <h2>Upcoming Catering Events</h2>
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
   <div style="width: 100%; max-height: 500px; overflow: auto; border: 1px solid #ccc; padding: 10px;">
    <table id="eventsTable" style="width: 1500px; min-width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width: 50px; position: sticky; top: 0; background-color: #4CAF50; color: white;">ID</th>
                    <th style="width: 80px; position: sticky; top: 0; background-color: #4CAF50; color: white;">User ID</th>
                    <th style="width: 150px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Service Name</th>
                    <th style="width: 120px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Amount</th>
                    <th style="width: 150px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Event Name</th>
                    <th style="width: 100px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Event Date</th>
                    <th style="width: 120px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Morning Persons</th>
                    <th style="width: 120px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Afternoon Persons</th>
                    <th style="width: 120px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Night Persons</th>
                    <th style="width: 120px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Veg Menu</th>
                    <th style="width: 120px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Non-Veg Menu</th>
                    <th style="width: 120px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Mixed Menu</th>
                    <th style="width: 150px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Menu Items</th>
                    <th style="width: 120px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Service Type</th>
                    <th style="width: 150px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Catering Service Count</th>
                    <th style="width: 150px; position: sticky; top: 0; background-color: #4CAF50; color: white;">Traveling Distance (KM)</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
</body>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("eventsTable");
    const headers = table.querySelectorAll("th");
    let sortDirection = {};

    headers.forEach((header, index) => {
        header.style.cursor = "pointer";
        header.addEventListener("click", () => {
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            // toggle asc/desc
            sortDirection[index] = !sortDirection[index];
            const direction = sortDirection[index] ? 1 : -1;

            // check if column values are numeric
            const isNumeric = rows.every(row => {
                let text = row.cells[index].innerText.trim().replace(/[₹,]/g, "");
                return !isNaN(text) && text !== "";
            });

            rows.sort((a, b) => {
                let aText = a.cells[index].innerText.trim();
                let bText = b.cells[index].innerText.trim();

                if (isNumeric) {
                    aText = parseFloat(aText.replace(/[₹,]/g, "")) || 0;
                    bText = parseFloat(bText.replace(/[₹,]/g, "")) || 0;
                }

                // for dates
                if (!isNumeric && /^\d{4}-\d{2}-\d{2}$/.test(aText) && /^\d{4}-\d{2}-\d{2}$/.test(bText)) {
                    aText = new Date(aText);
                    bText = new Date(bText);
                }

                return aText > bText ? direction : aText < bText ? -direction : 0;
            });

            rows.forEach(row => tbody.appendChild(row));

            // clear old arrows
            headers.forEach(h => h.innerText = h.innerText.replace(/ ↑| ↓/g, ""));
            // add arrow to current
            header.innerText += sortDirection[index] ? " ↑" : " ↓";
        });
    });
});
</script>

</html>

<?php
$stmt->close();
$conn->close();
?>
