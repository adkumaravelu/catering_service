
<?php
// Always start session before any output
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please login or sign up first.");
}

// Get the logged-in user ID from session
$userId = $_SESSION['user_id'];


// // Get the service and amount from URL
// $service = isset($_GET['service']) ? $_GET['service'] : '';
// $amount  = isset($_GET['amount']) ? $_GET['amount'] : '';

// // Optional: sanitize inputs
// $service = htmlspecialchars($service, ENT_QUOTES, 'UTF-8');
// $amount  = htmlspecialchars($amount, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Catering Event Registration</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 40px;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }
        .input-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .input-row input[type="text"],
        .input-row input[type="time"] {
            flex: 1;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="text"]#event_name, #catering_count, #traveling_distance, #Catering_Service, #total_amount, #user_id, #event_date {
            width: 100%;
            padding: 10px 12px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        input[type="text"]#event_name:focus, #catering_count:focus, #traveling_distance:focus, #Catering_Service, #total_amount, #user_id, #event_date {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.2);
        }
        .slot-options {
            display: flex;
            gap: 20px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        .slot-options label {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .slot-input {
            margin-top: 10px;
            display: none;
        }
        .food-type-section {
            margin-top: 20px;
        }
        .food-type-options {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        .food-type-options input[type="checkbox"] {
            margin-right: 5px;
        }
        .dropdown-container {
            margin-left: 10px;
            margin-bottom: 10px;
        }
        .dropdown-container select {
            width: 100%;
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #fff;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .dropdown-container select:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.2);
        }
        #menuButton {
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        #menuButton:hover {
            background-color: #45a049;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.6);
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            max-width: 700px;
            border-radius: 8px;
            position: relative;
        }
        .modal-content iframe {
            width: 100%;
            height: 400px;
            border: none;
        }
        .close {
            color: #aaa;
            font-size: 28px;
            position: absolute;
            top: 8px; right: 16px;
            cursor: pointer;
        }



.tooltip-icon {
  position: relative;
  display: inline-block;
  cursor: pointer;
  color: #007bff;
  font-size: 16px;
  margin-left: 5px;
}


.tooltip-icon .tooltip-text {
  visibility: hidden;
  width: 200px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 8px;
  position: absolute;
  z-index: 1;
  bottom: 125%; /* above the icon */
  left: 50%;
  transform: translateX(-50%);
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip-icon:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}

.submit-button,.back-btn {
    margin-top: 20px;
    width: 100%;
    padding: 12px;
    background-color: #28a745;
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-button:hover,.back-btn {
    background-color: #218838;
}



    </style>
</head>
<body>
    

<form id="eventForm" action="registerdb.php" method="POST">
    <h2>Catering Event Registration</h2>
    <!-- <p>User ID: <?php echo $userId; ?></p> -->

 <label>User ID:</label>
<input type="text" name="user_id" id="user_id" value="<?php echo htmlspecialchars($userId); ?>" readonly>
<br><br>

     <label>Catering Service Name</label>
        <input type="text" name="Catering_Service" id="Catering_Service"
       value="<?php echo isset($_GET['service']) ? htmlspecialchars($_GET['service']) : ''; ?>"
       readonly><br><br>

    <label>Event Name</label>
    <input type="text" name="event_name" id="event_name" placeholder="Enter Event Name" required><br><br>

     <label>Event Date:</label>
    <input type="date" name="event_date" id="event_date" placeholder="Enter Event Date" required><br><br>

    
    <div class="slot-options">
        <label><input type="checkbox" id="morning" onchange="toggleInput('morning')"> Morning</label>
        <label><input type="checkbox" id="afternoon" onchange="toggleInput('afternoon')"> Afternoon</label>
        <label><input type="checkbox" id="night" onchange="toggleInput('night')"> Night</label>
    </div>

    <div id="input-morning" class="slot-input" onchange="showViewMenuButton()">
        <div class="input-row" >
            <label style="min-width: 70px;">Morning:</label>
            <input type="text" id="morning_persons" name="morning_persons" placeholder="No. of Persons">
            
        </div>
    </div>

    <div id="input-afternoon" class="slot-input" onchange="showViewMenuButton()">
        <div class="input-row">
            <label style="min-width: 70px;">Afternoon:</label>
            <input type="text" id="afternoon_persons" name="afternoon_persons" placeholder="No. of Persons">
            
        </div>
    </div>

    <div id="input-night" class="slot-input" onchange="showViewMenuButton()">
        <div class="input-row">
            <label style="min-width: 70px;">Night:</label>
            <input type="text" id="night_persons" name="night_persons" placeholder="No. of Persons">
            
        </div>
    </div>
    <br><br>

    <!-- Food Type Checkboxes -->
<label>Food Type:</label><br>
<div class="food-type-options">
    <label><input type="checkbox" id="veg" onchange="toggleDropdown(this)"> Veg</label>
    <label><input type="checkbox" id="nonveg" onchange="toggleDropdown(this)"> Non-Veg</label>
    <label><input type="checkbox" id="mixed" onchange="toggleDropdown(this)"> Mixed</label>
</div>

<!-- Veg Dropdown -->
<div id="veg-options" class="dropdown-container" style="display:none; margin-top: 10px;">
    <label>Select Veg Menu:</label>
    <select name="veg_menu" id="veg_menu" onchange="openMenuPage()">
        <option value="">Select a menu</option>
        <option value="veg-1">Veg-1</option>
        <option value="veg-2">Veg-2</option>
        <option value="veg-3">Veg-3</option>
    </select>
</div>

<!-- Non-Veg Dropdown -->
<div id="nonveg-options" class="dropdown-container" style="display:none; margin-top: 10px;">
    <label>Select Non-Veg Menu:</label>
    <select name="nonveg_menu" id="nonveg_menu" onchange="openMenuModal()">
        <option value="">Select a menu</option>
        <option value="nonveg-1">Non-Veg-1</option>
        <option value="nonveg-2">Non-Veg-2</option>
    </select>
</div>

<!-- Mixed Dropdown -->
<div id="mixed-options" class="dropdown-container" style="display:none; margin-top: 10px;">
    <label>Select Mixed Menu:</label>
    <select name="mixed_menu" id="mixed_menu" onchange="openMenuModal()">
        <option value="">Select a menu</option>
        <option value="mixed-1">Mixed (Veg & Non-Veg)-1</option>
        <option value="mixed-2">Mixed (Veg & Non-Veg)-2</option>
    </select>
</div>

<?php
if (!empty($_GET['dishes']) && is_array($_GET['dishes'])) {
    echo "<h3>Selected Dishes:</h3><ul>";
    foreach ($_GET['dishes'] as $dish) {
        echo "<li>" . htmlspecialchars($dish) . "</li>";
    }
    echo "</ul>";
}
?>

<!-- Hidden Form Inputs -->
 <input type="hidden" name="selected_dishes" id="selected_dishes">

<!-- Hidden container for menu name and amount -->
<div id="menuDetails" style="display: none;">
    <input type="hidden" id="menu_name"  readonly><br><br>

    <input type="hidden" id="menu_amount"  readonly><br><br>
</div>
<input type="hidden" id="menu_items" name="menu_items">
<input type="hidden" id="menu_amount" name="menu_amount">
<!-- <input type="hidden" id="menu_amount" value="0"> -->


<!-- View Menu Button -->
<!-- <button type="button" id="menuButton" onclick="openMenuModal()" style="display:none;">View Menu</button> -->


    <div id="menuModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeMenuModal()">&times;</span>
            <iframe id="menuFrame"></iframe>
        </div>
    </div><br><br>

   <label>Service Type:</label><br>
<input type="checkbox" name="service_type" value="Buffet" id="service-buffet" onclick="toggleService('buffet')"> Buffet
<input type="checkbox" name="service_type" value="Table Service" id="service-table" onclick="toggleService('table')"> Table Service
    <br><br>
<label>
  Catering Service:
  <span class="tooltip-icon">&#9432;
    <span class="tooltip-text">Service boy amount Rs.500</span>
  </span></label><br>
<input type="checkbox" id="catering-yes" onclick="handleCateringSelection('yes')"> Yes
<input type="checkbox" id="catering-no" onclick="handleCateringSelection('no')"> No



    <div id="catering-input" style="display:none; margin-top:10px;" onchange="calservice()">
        <label>Number of Catering Services:</label>
        <input type="text" id="catering_count" name="catering_count" placeholder="No of Person">
    </div><br><br>

    <label>Do You Want Transport:
        <span class="tooltip-icon">&#9432;
        <span class="tooltip-text">0-10KM = RS.500<br>11KM-20KM = RS.1000<br>21KM-35KM = RS.2000<br>above 35KM = RS.3000</span>
  </span></label><br>
    <input type="checkbox" id="transport-yes" onclick="handleDistance('yes')">yes
    <input type="checkbox" id="transport-no" onclick="handleDistance('no')">no

     <div id="traveling-input" style="display:none; margin-top:10px;" onchange="caldistance()">
        <label>Number of KMs:</label>
        <input type="text" id="traveling_distance" name="traveling_distance" placeholder="Enter dstance">
    </div><br><br>

     <label>Amount</label>
<input type="text" name="total_amount" id="total_amount" readonly>

<button type="submit" class="submit-button">Submit</button>
<!-- Fixed Top Bar -->
    <button onclick="window.location.href='../agent/carddetails.php'" class="back-btn">Back</button>
</form>

<script>
function receiveMenuSelection(menuName, amount, items) {
    document.getElementById('menu_name').value = menuName;
    document.getElementById('menu_amount').value = amount;
    document.getElementById('items').value = items.join(', ');
    alert("Selected Menu: " + menuName + " (₹" + amount + ")");
}

// event date 
window.addEventListener("DOMContentLoaded", function() {
    const eventDateInput = document.getElementById("event_date");
    
    const today = new Date();
    today.setDate(today.getDate() + 10); // add 10 days
    
    // Format as YYYY-MM-DD
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    
    const minDate = `${yyyy}-${mm}-${dd}`;
    eventDateInput.min = minDate;
});

// window.addEventListener("message", function(event) {
//     if (event.data && event.data.type === "menuSelection") {
        
//         // Fill hidden dishes field
//         document.getElementById("selected_dishes").value = event.data.dishes.join(', ');

//         // Fill menu details
//         document.getElementById("menu_name").value = event.data.menuName;
//         document.getElementById("menu_amount").value = event.data.menuAmount;

//         // Show the menu details section
//         document.getElementById("menuDetails").style.display = "block";

//         // Close modal
//         document.getElementById("menuModal").style.display = "none";
//     }
// });

window.addEventListener("message", function(event) {
    if (event.data && event.data.type === "menuSelection") {
        
        // Fill hidden dishes field
        document.getElementById("selected_dishes").value = event.data.dishes.join(', ');

        // Fill menu details
        document.getElementById("menu_name").value = event.data.menuName;
        document.getElementById("menu_amount").value = event.data.menuAmount;

        // Show the menu details section
        document.getElementById("menuDetails").style.display = "block";

        // Close modal
        document.getElementById("menuModal").style.display = "none";

        // ✅ Immediately calculate total after setting the amount
        getMenuTotalAmount();
    }
});





//     const menuPrices = {
//     'veg-1': 250,
//     'veg-2': 230,
//     'veg-3': 240,
//     'nonveg-1': 300,
//     'nonveg-2': 350,
//     'mixed-1': 400,
//     'mixed-2': 420
// };

function toggleInput(slot) {
    document.getElementById('input-' + slot).style.display = document.getElementById(slot).checked ? 'block' : 'none';
}

// food type
function toggleDropdown(checkbox) {
    // Uncheck other checkboxes
    const veg = document.getElementById('veg');
    const nonveg = document.getElementById('nonveg');
    const mixed = document.getElementById('mixed');
    const button = document.getElementById('menuButton');

    if (checkbox.id === 'veg') {
        nonveg.checked = false;
        mixed.checked = false;
    } else if (checkbox.id === 'nonveg') {
        veg.checked = false;
        mixed.checked = false;
    } else if (checkbox.id === 'mixed') {
        veg.checked = false;
        nonveg.checked = false;
    }

    // Toggle dropdowns
    document.getElementById('veg-options').style.display = veg.checked ? 'block' : 'none';
    document.getElementById('nonveg-options').style.display = nonveg.checked ? 'block' : 'none';
    document.getElementById('mixed-options').style.display = mixed.checked ? 'block' : 'none';

    // If all unchecked, clear everything and hide button
    if (!veg.checked && !nonveg.checked && !mixed.checked) {
        document.getElementById('veg_menu').value = '';
        document.getElementById('nonveg_menu').value = '';
        document.getElementById('mixed_menu').value = '';

        document.getElementById("menu_name").value = '';
        document.getElementById("menu_amount").value = '';
        button.style.display = 'none';
    }
}



//  Catering Service
function handleCateringSelection(option) {
    const yes = document.getElementById('catering-yes');
    const no = document.getElementById('catering-no');
    const inputDiv = document.getElementById('catering-input');
    if (option === 'yes') {
        yes.checked ? (no.checked = false, inputDiv.style.display = 'block') : inputDiv.style.display = 'none';
    } else {
        no.checked ? (yes.checked = false, inputDiv.style.display = 'none') : '';
    }
}

function openMenuPage() {
    let menu = "";

    if (document.getElementById("veg").checked) menu = document.getElementById("veg_menu").value;
    if (document.getElementById("nonveg").checked) menu = document.getElementById("nonveg_menu").value;
    if (document.getElementById("mixed").checked) menu = document.getElementById("mixed_menu").value;

    if (!menu) {
        alert("Please select a menu.");
        return;
    }

    document.getElementById("menuFrame").src = "menu.php?menu=" + encodeURIComponent(menu);
    document.getElementById("menuModal").style.display = "block";
}


function closeMenuModal() {
    document.getElementById("menuModal").style.display = "none";
    document.getElementById("menuFrame").src = "";
}

window.onclick = function(event) {
    const modal = document.getElementById("menuModal");
    if (event.target === modal) closeMenuModal();
}

// view menu button
// function showViewMenuButton() {
//     const vegMenu = document.getElementById("veg_menu").value;
//     const nonvegMenu = document.getElementById("nonveg_menu").value;
//     const mixedMenu = document.getElementById("mixed_menu").value;
//     const button = document.getElementById("menuButton");
//     const morningpersons = parseInt(document.getElementById("morning_persons").value) || 0;
//     const afternoonpersons = parseInt(document.getElementById("afternoon_persons").value) || 0;
//     const nightpersons = parseInt(document.getElementById("night_persons").value) || 0;
//     const selectedMenu = vegMenu || nonvegMenu || mixedMenu;
    
//     const menuPrices = {
//         'veg-1': 250,
//         'veg-2': 230,
//         'veg-3': 240,
//         'nonveg-1': 300,
//         'nonveg-2': 350,
//         'mixed-1': 400,
//         'mixed-2': 420
//     };

//     const isVeg = document.getElementById('veg').checked;
//     const isNonveg = document.getElementById('nonveg').checked;
//     const isMixed = document.getElementById('mixed').checked;

//     if (selectedMenu && (isVeg || isNonveg || isMixed)) {
//         const amount = menuPrices[selectedMenu] || 0;
//         const total=(morningpersons+afternoonpersons+nightpersons)*amount;
//         // alert("Selected Menu: " + selectedMenu + "\nAmount: ₹" + amount);
//         alert("Amount: ₹" + total);

//         document.getElementById("menu_name").value = selectedMenu;
//         document.getElementById("menu_amount").value = amount;
//         button.style.display = "inline-block";
//     } else {
//         button.style.display = "none";
//         document.getElementById("menu_name").value = '';
//         document.getElementById("menu_amount").value = '';
//     }
// }




// open menu
function openMenuModal() {
    const vegMenu = document.getElementById("veg_menu").value;
    const nonvegMenu = document.getElementById("nonveg_menu").value;
    const mixedmenu = document.getElementById("mixed_menu").value;
    const selectedMenu = vegMenu || nonvegMenu || mixedmenu ; // Pick whichever is selected

    if (!selectedMenu) {
        alert("Please select a menu before viewing.");
        return;
    }

    document.getElementById("menuFrame").src = "menu.php?menu=" + encodeURIComponent(selectedMenu);
    document.getElementById("menuModal").style.display = "block";
}

//transport
function handleDistance(option) {
    const yes = document.getElementById('transport-yes');
    const no = document.getElementById('transport-no');
    const inputDiv = document.getElementById('traveling-input');
    if (option === 'yes') {
        yes.checked ? (no.checked = false, inputDiv.style.display = 'block') : inputDiv.style.display = 'none';
    } else {
        no.checked ? (yes.checked = false, inputDiv.style.display = 'none') : '';
    }
}


// Service Type
function toggleService(selected) {
    const buffet = document.getElementById('service-buffet');
    const table = document.getElementById('service-table');

    if (selected === 'buffet') {
        if (buffet.checked) table.checked = false;
    } else if (selected === 'table') {
        if (table.checked) buffet.checked = false;
    }
}

const slots = ["morning", "afternoon", "night"];

// Attach event listeners once at page load
slots.forEach(slot => {
    const checkbox = document.getElementById(slot);
    const personsInput = document.getElementById(`${slot}_persons`);

    if (checkbox) checkbox.addEventListener("change", calculateTotalAmount);
    if (personsInput) personsInput.addEventListener("input", calculateTotalAmount);
});

function getMenuTotalAmount() {
    const menuAmount = parseFloat(document.getElementById("menu_amount").value) || 0;
    let totalPersons = 0;

    slots.forEach(slot => {
        const isChecked = document.getElementById(slot).checked;
        if (isChecked) {
            const persons = parseInt(document.getElementById(`${slot}_persons`).value) || 0;
            totalPersons += persons;
        }
    });

    const menuTotalAmount = menuAmount * totalPersons;
    console.log("Total persons:", totalPersons);
    console.log("Menu Amount:", menuAmount);
    console.log("Total Menu Amount:", menuTotalAmount);
    return menuTotalAmount; // ✅ return value properly
}

window.addEventListener("message", function(event) {
    if (event.data.type === "menuSelection") {
        // Store data in hidden inputs
        document.getElementById("menu_items").value = event.data.dishes.join(", ");
        document.getElementById("menu_name").value = event.data.menuName;
        document.getElementById("menu_amount").value = event.data.menuAmount;

        // Call a separate function to handle the menu display
        showMenuDetails(event.data.menuName, event.data.menuAmount, event.data.dishes);

        // Recalculate total if needed
        calculateTotalAmount();
    }
});

// Example function to display menu
function showMenuDetails(name, amount, items) {
    console.log("Menu Name:", name);
    console.log("Menu Amount:", amount);
    console.log("Menu Items:", items);

    // Optional: display in a hidden div or UI
    // document.getElementById("selectedMenuDisplay").innerHTML =
    //     `<strong>${name}</strong> - ₹${amount}<br>` + items.join(", ");
}


// calculate catering-service amount
function calservice(){
    const cateringcount = (parseInt(document.getElementById("catering_count").value) || 0)*500;
     return cateringcount;
}

// calculate distance amount
function caldistance() {
    const travelingdistance = parseInt(document.getElementById("traveling_distance").value) || 0;
    let travelingdistanceamount = 0;

    if (travelingdistance > 0 && travelingdistance <= 10) {
        travelingdistanceamount = 500;
    } else if (travelingdistance > 10 && travelingdistance <= 20) {
        travelingdistanceamount = 1000;
    } else if (travelingdistance > 20 && travelingdistance <= 35) {
        travelingdistanceamount = 2000;
    } else if (travelingdistance > 35) {
        travelingdistanceamount = 3500;
    }

    return travelingdistanceamount;
}


function calculateTotalAmount() {
    const menuAmount = getMenuTotalAmount();
    const serviceAmount = calservice();
    const travelAmount = caldistance();

    console.log("Menu Amount:", menuAmount);
    console.log("Service Amount:", serviceAmount);
    console.log("Travel Amount:", travelAmount);

    const total = menuAmount + serviceAmount + travelAmount;
    console.log("Total:", total);

    document.getElementById("total_amount").value = total;
}


window.addEventListener("DOMContentLoaded", function () {
    document.getElementById("morning_persons").addEventListener("input", calculateTotalAmount);
    document.getElementById("afternoon_persons").addEventListener("input", calculateTotalAmount);
    document.getElementById("night_persons").addEventListener("input", calculateTotalAmount);

    document.getElementById("catering_count").addEventListener("input", calculateTotalAmount);
    document.getElementById("traveling_distance").addEventListener("input", calculateTotalAmount);

    document.getElementById("veg_menu").addEventListener("change", calculateTotalAmount);
    document.getElementById("nonveg_menu").addEventListener("change", calculateTotalAmount);
    document.getElementById("mixed_menu").addEventListener("change", calculateTotalAmount);
});


</script>
</body>
</html>
