<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #e0f7fa 0%, #e1bee7 100%);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
    }

    .card {
      border-radius: 15px;
      background: rgba(255, 255, 255, 0.85);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      padding: 30px 40px;
      width: 320px;
      border: none;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #5e35b1;
      font-weight: bold;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
      font-size: 15px;
    }

    button[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #7e57c2;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-weight: bold;
    }

    button[type="submit"]:hover {
      background-color: #5e35b1;
    }

    a {
      display: block;
      text-align: right;
      font-size: 14px;
      color: #7e57c2;
      text-decoration: none;
      margin-top: 10px;
    }

    a:hover {
      text-decoration: underline;
      color: #5e35b1;
    }

    /* Toast CSS */
    #toast {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #5e35b1;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 16px;
      position: fixed;
      z-index: 999;
      left: 50%;
      top: 20px;
      font-size: 17px;
      opacity: 0;
      transition: opacity 0.5s ease;
    }
  </style>
</head>
<body>

  <form id="loginForm" class="card">
  <h2>Login</h2>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
  <a href="forgot.php">Forgot password?</a>
</form>

<div id="toast"></div>

<script>
function showToast(message, type = "info") {
    const toast = document.getElementById("toast");
    toast.innerText = message;
    toast.style.backgroundColor = type === "success" ? "#28a745" :
                                 type === "error" ? "#dc3545" : "#5e35b1";
    toast.style.visibility = "visible";
    toast.style.opacity = 1;
    setTimeout(() => {
        toast.style.opacity = 0;
        setTimeout(() => { toast.style.visibility = "hidden"; }, 500);
    }, 3000);
}

// AJAX form submit
document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('logindb.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        showToast(data.message, data.status);
        if (data.redirect) {
            setTimeout(() => { window.location.href = data.redirect; }, 1500);
        }
    })
    .catch(err => showToast("Something went wrong", "error"));
});
</script>

</body>
</html>
