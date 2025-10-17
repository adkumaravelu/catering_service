<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
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
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
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

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        button {
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
            margin-top: 10px;
        }

        button:hover {
            background-color: #5e35b1;
        }

        #otp-popup {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            display: none;
            justify-content: center;
            align-items: center;
            background: rgba(0,0,0,0.4);
        }

        .otp-card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            width: 300px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        #custom-alert {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.4);
    display: none;
    justify-content: center;
    align-items: center;
}
.alert-card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 280px;
    text-align: center;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}
.alert-card p {
    font-size: 16px;
    margin-bottom: 15px;
}
.alert-card button {
    background: #7e57c2;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}
.alert-card button:hover {
    background: #5e35b1;
}
    </style>
</head>
<body>

<form id="forgotForm" class="card">
    <h2>Forgot Password</h2>
    <input type="email" id="email" placeholder="Enter your email" required>
    <button type="button" id="sendOtpBtn">Send OTP</button>

    <div id="password-section" style="display:none;">
        <input type="password" id="newPassword" placeholder="Enter new password" required>
        <button type="submit">Update Password</button>
    </div>
</form>

<!-- OTP Popup -->
<div id="otp-popup">
    <div class="otp-card">
        <h3>Enter OTP</h3>
        <input type="text" id="otp" placeholder="Enter OTP">
        <button id="verifyOtpBtn">Verify OTP</button>
    </div>
</div>

<div id="custom-alert" style="display:none;">
  <div class="alert-card">
    <p id="alert-message"></p>
    <button onclick="closeAlert()">OK</button>
  </div>
</div>

<script>

function showAlert(message) {
    document.getElementById("alert-message").innerText = message;
    document.getElementById("custom-alert").style.display = "flex";
}

function closeAlert() {
    document.getElementById("custom-alert").style.display = "none";
}

const sendOtpBtn = document.getElementById("sendOtpBtn");
const otpPopup = document.getElementById("otp-popup");

sendOtpBtn.addEventListener("click", function () {
    const email = document.getElementById("email").value.trim();
    if (!email) {
        alert("Please enter an email.");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "forgotdb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        console.log("Send OTP Response:", xhr.responseText);
        if (xhr.responseText.includes("otp_sent")) {
    showAlert("OTP sent to your email.");
    otpPopup.style.display = "flex";
} else if (xhr.responseText.includes("email_not_found")) {
    showAlert("Email not found.");
} else if (xhr.responseText.includes("failed_to_send")) {
    showAlert("Failed to send OTP.");
} else {
    showAlert("Unexpected: " + xhr.responseText);
}

        
    };
    xhr.send("action=send_otp&email=" + encodeURIComponent(email));
});

document.getElementById("verifyOtpBtn").addEventListener("click", function () {
    const email = document.getElementById("email").value.trim();
    const otp = document.getElementById("otp").value.trim();

    if (!otp) {
        showAlert("Enter OTP.");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "forgotdb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        console.log("Verify OTP Response:", xhr.responseText);
        if (xhr.status === 200) {
            if (xhr.responseText.includes("otp_valid")) {
                showAlert("✅ OTP verified. You can now reset your password.");
                otpPopup.style.display = "none";
                document.getElementById("password-section").style.display = "block";
                sendOtpBtn.style.display = "none";
            } else if (xhr.responseText.includes("otp_expired")) {
                showAlert("⚠️ OTP expired. Please request a new one.");
            } else {
                showAlert("❌ Invalid OTP.");
            }
        } else {
            showAlert("Unexpected error. Please try again.");
        }
    };
    xhr.send(
        "action=verify_otp&email=" + encodeURIComponent(email) + "&otp=" + encodeURIComponent(otp)
    );
});


document.getElementById("forgotForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const newPassword = document.getElementById("newPassword").value;

    if (!newPassword || newPassword.length < 6) {
        showAlert("⚠️ Password must be at least 6 characters.");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "forgotdb.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        console.log("Update Password Response:", xhr.responseText);
        if (xhr.status === 200) {
            if (xhr.responseText.includes("updated")) {
                showAlert("✅ Password updated successfully.");
                setTimeout(() => {
                    window.location.href = "login.php";
                }, 1500); // delay so user can see the success alert
            } else {
                showAlert("❌ Failed: " + xhr.responseText);
            }
        } else {
            showAlert("Unexpected error. Please try again.");
        }
    };
    xhr.send(
        "action=update_password&email=" + encodeURIComponent(email) +
        "&newPassword=" + encodeURIComponent(newPassword)
    );
});

</script>

</body>
</html>
