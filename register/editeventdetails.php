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

$today = date('Y-m-d');
$stmt = $conn->prepare("SELECT * FROM register WHERE event_date >= ? AND status = 0");
$stmt->bind_param("s", $today);
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
        td[contenteditable="true"] { background-color: #fff8dc; }
        #removeBtn { float: right; margin-bottom: 10px; padding: 8px 12px; background-color: red; color: white; border: none; cursor: pointer; }
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
    <button id="removeBtn">Remove Selected</button>

    <div style="width: 100%; overflow-x: auto;">
        <table id="eventsTable">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Service Name</th>
                    <th>Amount</th>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Morning Persons</th>
                    <th>Afternoon Persons</th>
                    <th>Night Persons</th>
                    <th>Veg Menu</th>
                    <th>Non-Veg Menu</th>
                    <th>Mixed Menu</th>
                    <th>Menu Items</th>
                    <th>Service Type</th>
                    <th>Catering Service Count</th>
                    <th>Traveling Distance (KM)</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr data-id="<?php echo $row['id']; ?>">
                    <td><input type="checkbox" class="rowCheckbox"></td>
                    <td><?php echo $row['id']; ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['service_name']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['amount']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['event_name']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['event_date']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['morning_persons']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['afternoon_persons']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['night_persons']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['veg_menu']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['nonveg_menu']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['mixed_menu']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['menu_items']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['service_type']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['cating_service']); ?></td>
                    <td contenteditable="true"><?php echo htmlspecialchars($row['traveling_distance']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<script>
// Remove selected rows
document.getElementById('removeBtn').addEventListener('click', function() {
    let checkedBoxes = document.querySelectorAll('.rowCheckbox:checked');
    let ids = Array.from(checkedBoxes).map(cb => cb.closest('tr').dataset.id);
    if(ids.length === 0) { alert('Select at least one row'); return; }

    if(confirm('Are you sure you want to remove selected events?')) {
        fetch('editeventdetailsdb.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ids: ids})
        })
        .then(res => res.text())
        .then(res => {
            alert(res);
            location.reload();
        });
    }
});

// Update inline edited cells
document.querySelectorAll('#eventsTable td[contenteditable="true"]').forEach(td => {
    td.addEventListener('blur', function() {
        let tr = td.closest('tr');
        let id = tr.dataset.id;
        let columnIndex = td.cellIndex;
        let columnName = tr.parentNode.parentNode.querySelector('thead tr').children[columnIndex].innerText.replace(/\s/g,'_');
        let value = td.innerText;

        fetch('editeventdetailsdb.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id: id, column: columnName, value: value})
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("eventsTable");
    const headers = table.querySelectorAll("th");
    let sortDirection = {}; // store direction for each column

    headers.forEach((header, index) => {
        // skip the "Select" column
        if (index === 0) return;

        header.style.cursor = "pointer";
        header.addEventListener("click", () => {
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            // toggle asc/desc
            sortDirection[index] = !sortDirection[index];
            const direction = sortDirection[index] ? 1 : -1;

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

                return aText > bText ? direction : aText < bText ? -direction : 0;
            });

            // re-append rows in sorted order
            rows.forEach(row => tbody.appendChild(row));

            // remove any previous arrows
            headers.forEach(h => h.innerText = h.innerText.replace(/ ↑| ↓/g, ""));
            // add arrow for current column
            header.innerText += sortDirection[index] ? " ↑" : " ↓";
        });
    });
});
</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
