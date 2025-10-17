<?php
session_start();

// Fetch agent details from GET (sent from login redirect)
$agentId    = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$agentName  = isset($_GET['name']) ? $_GET['name'] : '';
$agentEmail = isset($_GET['email']) ? $_GET['email'] : '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Agent</title>
  <style>
 /* Reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Segoe UI", Arial, sans-serif;
  background: linear-gradient(135deg, #2193b0, #6dd5ed);
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 20px;
}

/* Card */
.form-container {
  background: #fff;
  padding: 30px 25px;
  width: 100%;
  max-width: 480px;
  border-radius: 14px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
  text-align: center;
  word-wrap: break-word;
  overflow: hidden;
  animation: fadeIn 0.6s ease-in-out;
}

.form-container h2 {
  margin-bottom: 20px;
  color: #333;
  font-size: 22px;
  font-weight: 600;
}

.form-container label {
  display: block;
  margin: 12px 0 6px;
  text-align: left;
  font-weight: 600;
  font-size: 14px;
  color: #444;
}

.form-container input,
.form-container textarea {
  width: 100%;
  padding: 10px 12px;
  margin-bottom: 12px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
  transition: border-color 0.2s;
}

.form-container input:focus,
.form-container textarea:focus {
  border-color: #2193b0;
  outline: none;
}

.form-container input[type="file"] {
  border: none;
  padding: 5px 0;
}

button {
  padding: 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
  transition: all 0.3s ease;
}

button[type="submit"] {
  background: #2193b0;
  color: #fff;
  width: 48%;
}

button[type="submit"]:hover {
  background: #1a7a91;
}

.back-btn {
  background: #f44336;
  color: #fff;
  width: 48%;
}

.back-btn:hover {
  background: #d32f2f;
}

.btn-group {
  display: flex;
  justify-content: space-between;
  gap: 10px;
  margin-top: 15px;
}

@media (max-width: 600px) {
  .form-container {
    max-width: 95%;
    padding: 20px;
  }
  button {
    width: 100%;
  }
  .btn-group {
    flex-direction: column;
  }
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Add Agent</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Agent ID:</label>
      <input type="text" name="agent_id" value="<?= htmlspecialchars($agentId) ?>" readonly>

      <label>Agent Name:</label>
      <input type="text" name="agent_name" value="<?= htmlspecialchars($agentName) ?>" readonly>

      <label>Agent Email:</label>
      <input type="text" name="agent_email" value="<?= htmlspecialchars($agentEmail) ?>" readonly>

      <label>Catering Name:</label>
      <input type="text" name="name" required>

      <label>Amount:</label>
      <input type="number" name="amount" required>

      <label>Rating (1-5):</label>
      <input type="number" name="rating" step="0.1" min="1" max="5" required>

      <label>Description:</label>
      <textarea name="description" rows="3"></textarea>

      <label>Upload PDF File:</label>
      <input type="file" name="pdf_file" accept="application/pdf" required>

      <div class="btn-group">
        <button type="submit" name="sendMail">Send Mail</button>
        <button type="button" class="back-btn" onclick="window.location.href='../login/login.php'">Back</button>
      </div>
    </form>
  </div>
</body>
</html>

<?php
// ============== EMAIL CONFIG ==============
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';
require __DIR__ . '/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sendMail'])) {
    $agentId    = $_POST['agent_id'];
    $agentName  = $_POST['agent_name'];
    $agentEmail = $_POST['agent_email'];
    $name        = $_POST['name'];
    $amount      = $_POST['amount'];
    $rating      = $_POST['rating'];
    $description = $_POST['description'];

    // Handle PDF Upload
    $pdfPath = "";
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
        $targetDir = __DIR__ . "/uploads/";
        if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
        $fileName   = time() . "_" . basename($_FILES['pdf_file']['name']);
        $targetFile = $targetDir . $fileName;

        if (mime_content_type($_FILES['pdf_file']['tmp_name']) === "application/pdf") {
            move_uploaded_file($_FILES['pdf_file']['tmp_name'], $targetFile);
            $pdfPath = $targetFile;
        } else {
            die("<script>alert('Only PDF files allowed!'); window.history.back();</script>");
        }
    }

// DB connection
$conn = new mysqli("localhost", "root", "", "catering");
if ($conn->connect_error) { die("DB connection failed: " . $conn->connect_error); }

// ✅ Check if agent_email already exists
$check = $conn->prepare("SELECT id FROM agent_request WHERE agent_email = ? LIMIT 1");
$check->bind_param("s", $agentEmail);
$check->execute();
$check->store_result();

// ✅ Check if agent_email already exists
$check = $conn->prepare("SELECT id FROM agent_request WHERE agent_email = ? LIMIT 1");
$check->bind_param("s", $agentEmail);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
            Swal.fire({
              icon:'info',
              title:'Already Exists',
              text:'We found your existing request. Redirecting to history...'
            }).then(()=>{window.location.href='agenthistory.php?agent_id=$agentId';});
          </script>";
    exit;
}

$check->close();


// Insert into agent_request
$stmt = $conn->prepare("INSERT INTO agent_request 
    (agent_id, agent_name, agent_email, catering_name, amount, rating, description, pdf_file) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssddss", $agentId, $agentName, $agentEmail, $name, $amount, $rating, $description, $pdfPath);
$stmt->execute();
$stmt->close();


    // Fetch Admin Email from DB
    $conn = new mysqli("localhost", "root", "", "catering");
    if ($conn->connect_error) { die("DB connection failed: " . $conn->connect_error); }
    $sql = "SELECT email FROM signup WHERE role = 'admin' LIMIT 1";
    $result = $conn->query($sql);
    $admin_email = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['email'] : '';

    if (!$admin_email) {
        die("<script>alert('Admin email not found in DB!'); window.history.back();</script>");
    }

    // Send Email
   // Send Email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kumaraveluad@gmail.com';   // your Gmail
    $mail->Password   = 'sxrtjbstvfukqpsu';         // your Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // IMPORTANT: From address must be same as Gmail username
    $mail->setFrom('kumaraveluad@gmail.com', 'Catering Service');
    $mail->addAddress($admin_email);

    // Attachment
    if (!empty($pdfPath)) {
        $mail->addAttachment($pdfPath);
    }

    $mail->isHTML(true);
    $mail->Subject = "New Catering Agent Added";
    $mail->Body    = "
        <h3>New Agent Details</h3>
        <p><strong>Agent ID:</strong> $agentId</p>
        <p><strong>Agent Name:</strong> $agentName</p>
        <p><strong>Agent Email:</strong> $agentEmail</p>
        <p><strong>Catering Name:</strong> $name</p>
        <p><strong>Amount:</strong> ₹$amount</p>
        <p><strong>Rating:</strong> $rating ⭐</p>
        <p><strong>Description:</strong> $description</p>";

    // Fix SSL issues on older PHP
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        )
    );

    $mail->send();
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
            Swal.fire({icon:'success',title:'Mail Sent!',text:'Details sent to Admin ($admin_email) with PDF!'})
            .then(()=>{window.location.href='../login/login.php';});
          </script>";
} catch (Exception $e) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
            Swal.fire({icon:'error',title:'Oops...',text:'Failed to send mail: " . addslashes($mail->ErrorInfo) . "'})
            .then(()=>{window.location.href='addagent.php';});
          </script>";
}

}
?>
