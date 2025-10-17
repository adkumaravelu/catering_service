<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

// Fetch all users with status = 0
$sql = "SELECT * FROM signup WHERE status = 0 AND email != 'adk972002@gmail.com'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h3 style='text-align:center;'>Users Details</h3>";

    echo '<div style="text-align: left; margin-bottom: 10px;">
        <button onclick="window.location.href=\'../admin/admin.php\'" 
                style="padding: 8px 16px; 
                       background-color: #4CAF50; 
                       color: white; 
                       border: none; 
                       border-radius: 4px; 
                       cursor: pointer;">Back
        </button>
      </div>';

    // Table styling
    echo "<style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px 15px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        h3 {
            font-family: Arial, sans-serif;
            color: #333;
        }
    </style>";

    echo "<table id='userTable'>";
    echo "<tr>
            <th onclick='sortTable(0)'>ID</th>
            <th onclick='sortTable(1)'>Name</th>
            <th onclick='sortTable(2)'>Phone</th>
            <th onclick='sortTable(3)'>Email</th>
            <th onclick='sortTable(4)'>Password</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['id'])."</td>";
        echo "<td>".htmlspecialchars($row['name'])."</td>";
        echo "<td>".htmlspecialchars($row['phone'])."</td>";
        echo "<td>".htmlspecialchars($row['email'])."</td>";
        echo "<td>".htmlspecialchars($row['password'])."</td>";
        echo "</tr>";
    }

    echo "</table>";

    // JS sorting function
    echo "<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById('userTable');
        switching = true;
        dir = 'asc'; 
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName('TD')[n];
                y = rows[i + 1].getElementsByTagName('TD')[n];
                if (dir == 'asc') {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == 'desc') {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == 'asc') {
                    dir = 'desc';
                    switching = true;
                }
            }
        }
    }
    </script>";
} else {
    echo "<p style='text-align:center; color:red;'>No users with status 0 found.</p>";
}

$conn->close();
?>
