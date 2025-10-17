<!DOCTYPE html>
<html>
<head>
  <title>Add Catering Service</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background: #f0f0f0;
    }

    .form-container {
      background: white;
      padding: 25px;
      max-width: 600px;
      margin: auto;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background: #45a049;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Add Catering Service</h2>
<form id="cateringForm" action="addcarddb.php" method="POST">
      <label>Catering Name:</label>
      <input type="text" id="name" name="name" required>

      <label>Amount:</label>
      <input type="number" id="amount" name="amount" required>

      
<label>Rating (1-5):</label>
<input type="number" id="rating" name="rating" step="0.1" min="1" max="5" required>

      <label>Description:</label>
      <textarea id="description" name="description" rows="3"></textarea>

      <label>Image URL:</label>
      <input type="text" id="image" name="image" required>

      <button type="submit">Finish</button>
       <button onclick="window.location.href='../admin/admin.php'" 
                style="padding: 8px 16px; 
                       background-color: #4CAF50; 
                       color: white; 
                       border: none; 
                       border-radius: 4px; 
                       cursor: pointer;">
            Back
        </button>
    </form>
  </div>
</body>
</html>
