<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    text-align: center;
    padding-top: 50px;
  }
  h2 {
    margin-bottom: 30px;
  }
  button {
    display: block;
    width: 200px;
    margin: 10px auto;
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    border: none;
    background-color: #007bff;
    color: white;
  }
  button:hover {
    background-color: #0056b3;
  }
  #log{
    margin-right:0px;
    background-color:green;
  }
  #log:active{
    background-color:red;
  }
</style>

</head>
<body>
  <button onclick="location.href='../login/login.php'" id="log">Logout</button>
  <h2>ADMIN</h2>
  <button onclick="location.href='../agent/addcard.php'">Add Agent</button>
  <button onclick="location.href='../agent/removeagent.php'">Remove Agent</button>
  <button onclick="location.href='../agent/activateagent.php'">Acivate Agent </button>
  <button onclick="location.href='../register/eventdetails.php'">Events Details</button>
  <button onclick="location.href='../register/editeventdetails.php'">Remove / Edit Events</button>
  <button onclick="location.href='../register/eventhistory.php'">Event History</button>
  <button onclick="location.href='../signup/userdetails.php'">User Details</button>
  <button onclick="location.href='../signup/removeuserdetails.php'">Remove User </button>
  <button onclick="location.href='../signup/removeduser.php'">Acivate Users </button>

</body>
</html>
