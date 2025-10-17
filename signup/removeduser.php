<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

// Fetch all users with status = 0
$sql = "SELECT * FROM signup WHERE status = 1 AND email != 'adk972002@gmail.com'"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users Details</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #4CAF50; color: white; cursor: pointer; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #ddd; }
        #removeBtn { float: right; margin: 10px 5%; padding: 8px 12px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<h3 style="text-align:center;">Users Details</h3>
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
<button id="removeBtn">Activate</button>

<table id="usersTable">
    <thead>
        <tr>
            <th>Select</th>
            <th data-column="1">ID</th>
            <th data-column="2">Name</th>
            <th data-column="3">Phone</th>
            <th data-column="4">Email</th>
            <th data-column="5">Password</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr data-id="<?php echo $row['id']; ?>">
            <td><input type="checkbox" class="rowCheckbox"></td>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['password']); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script>
// Sorting logic
document.querySelectorAll("#usersTable th[data-column]").forEach(th => {
    th.addEventListener("click", function() {
        let table = document.getElementById("usersTable").tBodies[0];
        let rows = Array.from(table.rows);
        let column = this.getAttribute("data-column");
        let asc = this.asc = !this.asc; // Toggle ASC/DESC

        rows.sort((a, b) => {
            let A = a.cells[column].innerText.toLowerCase();
            let B = b.cells[column].innerText.toLowerCase();

            // Check if numbers
            if(!isNaN(A) && !isNaN(B)) {
                return asc ? A - B : B - A;
            }
            return asc ? A.localeCompare(B) : B.localeCompare(A);
        });

        rows.forEach(row => table.appendChild(row));
    });
});

// Remove selected users
document.getElementById('removeBtn').addEventListener('click', function() {
    let checkedBoxes = document.querySelectorAll('.rowCheckbox:checked');
    let ids = Array.from(checkedBoxes).map(cb => cb.closest('tr').dataset.id);
    if(ids.length === 0) { alert('Select at least one user'); return; }

    if(confirm('Are you sure you want to remove selected users?')) {
        fetch('removeuserdb.php', {
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
</script>

</body>
</html>

<?php $conn->close(); ?>
