<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Signup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body{
      background: linear-gradient(135deg, #e0f7fa 0%, #e1bee7 100%);
      height: 100vh; margin:0;
      display:flex; align-items:center; justify-content:center; flex-direction:column;
    }
    .glass-card,.glass-modal{
      border-radius:15px; background:rgba(255,255,255,.15);
      backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px);
      box-shadow:0 8px 25px rgba(0,0,0,.2); border:1px solid rgba(255,255,255,.25);
    }
    #alertBox{
      position:fixed; top:10px; left:50%; transform:translateX(-50%);
      z-index:9999; width:90%; max-width:520px; display:none;
    }
    input::placeholder{ color:rgba(0,0,0,.5) }
    .btn-success{ background:#7e57c2; border:none }
    .btn-success:hover{ background:#5e35b1 }
  </style>
</head>
<body>

  <!-- Top alert -->
  <div id="alertBox"></div>

  <!-- Signup card -->
  <div class="glass-card p-4" style="width:360px;">
    <h3 class="text-center mb-3 text-primary fw-bold">Signup</h3>

    <form id="signupForm" onsubmit="return false;">
      <div class="mb-3">
        <input type="text" class="form-control" id="name" placeholder="Full Name" required />
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" id="phone" placeholder="Mobile Number" required />
      </div>
      <div class="mb-3">
        <input type="email" class="form-control" id="email" placeholder="Email" required />
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" id="password" placeholder="Password" required />
      </div>

<div class="mb-3">
  <select class="form-control" id="role" required>
    <option value="">-- Select Role --</option>
    <option value="user">User</option>
    <option value="agent">Agent</option>
    
  </select>
</div>


      <button type="button" id="sendOtpBtn" class="btn btn-success w-100">Send OTP</button>

      <p class="text-center mt-3">
        Already have an account?
        <a href="../login/login.php" class="fw-bold text-decoration-none text-primary">Login</a>
      </p>
    </form>
  </div>

  <!-- OTP Modal -->
  <div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content glass-modal p-3">
        <h5 class="modal-title text-center text-primary fw-bold mb-3">Enter OTP</h5>
        <input type="text" id="otp" class="form-control mb-3" placeholder="Enter OTP" />
        <button id="verifyBtn" class="btn btn-success w-100 mb-2">Verify & Signup</button>
        <button class="btn btn-danger w-100" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const alertBox = document.getElementById('alertBox');
    const otpModal = new bootstrap.Modal(document.getElementById('otpModal'));

    function showAlert(msg, type='danger', timeout=5000){
      alertBox.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
          ${msg}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;
      alertBox.style.display = 'block';
      if(timeout){
        setTimeout(()=>{ alertBox.style.display='none'; }, timeout);
      }
    }

    document.getElementById('sendOtpBtn').addEventListener('click', function(){
      const name = document.getElementById('name').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;
      const role = document.getElementById('role').value;
if(!['user','agent'].includes(role)){
  errors.push('Please select a valid role (user or agent).');
}


      const errors=[];
      if(name.length<3) errors.push('Name must be at least 3 characters.');
      if(!/^\d{10}$/.test(phone)) errors.push('Enter a valid 10-digit phone number.');
      if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Invalid email.');
      if(!/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_]).{8,}$/.test(password)){
        errors.push('Password must be 8+ chars with upper, lower, and special char.');
      }

      if(errors.length){ showAlert(errors.join('<br>'), 'warning'); return; }

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'send_otp.php', true); // ✅ SEND OTP endpoint
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function(){
        try{
          const res = JSON.parse(xhr.responseText || '{}');
          if(res.status === 'ok'){
            showAlert(res.message || 'OTP sent.', 'success', 3000);
            otpModal.show();
          }else{
            showAlert(res.message || 'Failed to send OTP.', 'danger');
          }
        }catch(e){
          showAlert('Unexpected response from server.', 'danger');
        }
      };
      xhr.send(
        'name='+encodeURIComponent(name)+
        '&phone='+encodeURIComponent(phone)+
        '&email='+encodeURIComponent(email)+
        '&password='+encodeURIComponent(password)+
        '&role='+encodeURIComponent(role)
      );
    });

    document.getElementById('verifyBtn').addEventListener('click', function(){
      const otp = document.getElementById('otp').value.trim();
      if(!otp){ showAlert('Please enter OTP.', 'warning'); return; }

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'signupdb.php', true); // ✅ VERIFY + CREATE endpoint
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function(){
        try{
          const res = JSON.parse(xhr.responseText || '{}');
          if(res.status === 'ok'){
            showAlert(res.message || 'Signup success!', 'success', 2000);
            setTimeout(()=>{ window.location.href = '../login/login.php'; }, 1500);
          }else{
            showAlert(res.message || 'Invalid OTP or session expired.', 'danger');
          }
        }catch(e){
          showAlert('Unexpected response from server.', 'danger');
        }
      };
      xhr.send('otp='+encodeURIComponent(otp));
    });
  </script>
</body>
</html>
