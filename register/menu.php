<!DOCTYPE html>
<html>
<head>
  <title>Menu Details</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
    h2 { color: #4CAF50; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
    ul { list-style-type: square; padding-left: 20px; }
    li { margin-bottom: 6px; }
    .add-section { margin-top: 20px; }
    input[type="text"] { padding: 8px; font-size: 14px; width: 250px; margin-right: 10px; }
    button { padding: 8px 12px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 5px; }
    button:hover { background-color: #45a049; }
  </style>
</head>
<body>

<?php
$menu = $_GET['menu'];

$items = [
    'veg-1' => ['items' => ['Paneer Butter Masala', 'Dal Tadka', 'Veg Pulao'], 'amount' => 250],
    'veg-2' => ['items' => ['Aloo Gobi', 'Roti', 'Gulab Jamun'], 'amount' => 230],
    'veg-3' => ['items' => ['Chole', 'Jeera Rice', 'Mixed Veg Salad'], 'amount' => 240],
    'nonveg-1' => ['items' => ['Chicken Curry', 'Chicken Biryani', 'Raita'], 'amount' => 300],
    'nonveg-2' => ['items' => ['Mutton Masala', 'Fried Rice', 'Kebab'], 'amount' => 350],
    'mixed-1' => ['items' => ['Paneer Butter Masala', 'Dal Tadka', 'Chicken Curry', 'Chicken Biryani', 'Raita'], 'amount' => 400],
    'mixed-2' => ['items' => ['Chole', 'Jeera Rice', 'Mutton Masala', 'Fried Rice', 'Kebab'], 'amount' => 420]
];

if (isset($items[$menu])) {
    $menuTitle = ucfirst(str_replace('-', ' ', $menu));
    $menuAmount = $items[$menu]['amount'];
    $menuItems = $items[$menu]['items'];

    echo "<h2 id='currentMenuName'>" . htmlspecialchars($menuTitle) . "</h2>";
    echo "<ul id='menuList'>";
    foreach ($menuItems as $item) {
        echo "<li>" . htmlspecialchars($item) . "</li>";
    }
    echo "</ul>";
    // store amount in data-amount so JS can always get the number
    echo "<p><strong>Base Amount:</strong> ₹<span id='currentMenuAmount' data-amount='" . htmlspecialchars($menuAmount) . "'>" . htmlspecialchars($menuAmount) . "</span></p>";
}
?>


<div class="add-section">
  <input type="text" id="newItem" placeholder="Enter new menu item">
  <button type="button" onclick="addMenuItem()">Add More Menu Item</button>
</div>

<button type="button" onclick="sendDishes()">Done</button>




<script>
function addMenuItem() {
    const input = document.getElementById('newItem');
    const value = input.value.trim();

    if (value) {
        const ul = document.getElementById('menuList');
        const li = document.createElement('li');
        li.textContent = value;
        ul.appendChild(li);

        input.value = ''; // clear input
        updateAmount(); // recalculate amount
    }
}

function updateAmount() {
    const itemCount = document.querySelectorAll('#menuList li').length;
    const menuName = document.getElementById("currentMenuName").textContent.toLowerCase();
    let newAmount = 0;

    if (menuName.includes("nonveg")) {
        // Rule for Non-Veg
        if (itemCount <= 5) {
            newAmount = 250;
        } else if (itemCount <= 10) {
            newAmount = 500;
        } else {
            newAmount = 750; // you can adjust if needed
        }
    } else {
        // Rule for Veg / Mixed
        if (itemCount <= 5) {
            newAmount = 100;
        } else if (itemCount <= 10) {
            newAmount = 200;
        } else if (itemCount <= 15) {
            newAmount = 350;
        } else {
            newAmount = 400;
        }
    }

    const amountSpan = document.getElementById("currentMenuAmount");
    amountSpan.textContent = newAmount;
    amountSpan.setAttribute("data-amount", newAmount);
}

function sendDishes() {
    const input = document.getElementById('newItem');
    if (input.value.trim()) {
        addMenuItem();
    }

    let selectedDishes = [...document.querySelectorAll('#menuList li')]
                          .map(li => li.textContent.trim());

    let menuName = document.getElementById("currentMenuName").textContent.trim();
    let menuAmount = parseFloat(document.getElementById("currentMenuAmount")
                                .getAttribute("data-amount")) || 0;

    console.log("Sending to parent: " + JSON.stringify({
        dishes: selectedDishes,
        menuName: menuName,
        menuAmount: menuAmount
    }));

    window.parent.postMessage({
        type: "menuSelection",
        dishes: selectedDishes,
        menuName: menuName,
        menuAmount: menuAmount
    }, "*");
}

// Run on load
updateAmount();
</script>




</body>
</html>
