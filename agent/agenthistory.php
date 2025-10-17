<?php
// agenthistory.php
session_start();
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) { die("DB connection failed: " . $conn->connect_error); }

$agentId = isset($_GET['agent_id']) ? $_GET['agent_id'] : '';

if (!$agentId) {
    die("<p>No agent ID provided!</p>");
}

$sql = "SELECT user_id, service_name, amount, event_name, event_date,
               morning_persons, afternoon_persons, night_persons,
               veg_menu, nonveg_menu, mixed_menu, service_type, cating_service,
               traveling_distance, menu_items
        FROM register WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $agentId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Agent History</title>
 <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f9;
      padding: 20px;
    }
    .back-btn {
      display: inline-block;
      margin-bottom: 15px;
      padding: 8px 14px;
      background: #2193b0;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      font-size: 14px;
      font-weight: bold;
      transition: background 0.3s;
    }
    .back-btn:hover {
      background: #17657a;
    }
    h2 { margin-bottom: 20px; }
    table {
      border-collapse: collapse;
      width: 100%;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
      font-size: 14px;
    }
    th {
      background: #2193b0;
      color: #fff;
    }
    tr:nth-child(even) { background: #f9f9f9; }
  </style>
</head>
<body>
    <a href="../login/login.php" class="back-btn">Back</a>
  <h2>Agent Service / Event History</h2>

  <?php if ($result->num_rows > 0): ?>
  <table>
    <thead>
      <tr>
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
        <th>Service Type</th>
        <th>Catering Service</th>
        <th>Travel Distance</th>
        <th>Menu Items</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['user_id']) ?></td>
          <td><?= htmlspecialchars($row['service_name']) ?></td>
          <td><?= htmlspecialchars($row['amount']) ?></td>
          <td><?= htmlspecialchars($row['event_name']) ?></td>
          <td><?= htmlspecialchars($row['event_date']) ?></td>
          <td><?= htmlspecialchars($row['morning_persons']) ?></td>
          <td><?= htmlspecialchars($row['afternoon_persons']) ?></td>
          <td><?= htmlspecialchars($row['night_persons']) ?></td>
          <td><?= htmlspecialchars($row['veg_menu']) ?></td>
          <td><?= htmlspecialchars($row['nonveg_menu']) ?></td>
          <td><?= htmlspecialchars($row['mixed_menu']) ?></td>
          <td><?= htmlspecialchars($row['service_type']) ?></td>
          <td><?= htmlspecialchars($row['cating_service']) ?></td>
          <td><?= htmlspecialchars($row['traveling_distance']) ?></td>
          <td><?= htmlspecialchars($row['menu_items']) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p>On Procssing....</p>
  <?php endif; ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
