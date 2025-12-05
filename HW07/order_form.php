<?php
$servername = "localhost";
$username = "upwi4zp6hjp2s";
$password = "wonkypassword";
$dbname = "dbkqjfku1aachq";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function selectQuan($id) {
    echo "<select name='item_" . $id . "' id='item_" . $id . "'>";
    for ($i = 0; $i <= 10; $i++) {
        echo "<option value='$i'>$i</option>";
    }
    echo "</select>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>The Mynock-Bite Diner - Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }
        .menu-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .menu-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            box-sizing: border-box;
            width: 350px;
            display: flex;
            flex-direction: column;
            text-align: center;
        }
        .menu-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .item-name {
            font-size: 1.3em;
            font-weight: bold;
        }
        .item-price {
            font-size: 1.2em;
            color: #008000;
            font-weight: bold;
        }
        .item-desc {
            font-size: 0.9em;
            color: #555;
            text-align: left;
            margin-bottom: 15px;
            flex-grow: 1;
        }
        .item-select {
            font-weight: bold;
        }
        .customer-info {
            background-color: #fff;
            padding: 20px;
            margin-top: 30px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .customer-info h2 {
            margin-top: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group textarea {
            width: 98%;
            max-width: 400px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            height: 80px;
            resize: vertical;
        }
        .submit-btn {
            background-color: #eeda4a;
            color: #1a1a1a;
            font-weight: bold;
            font-size: 1.2em;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #d4c043;
        }
        #error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <form method="get" action="process_order.php" id="orderForm">
            
            <div class="menu-grid">
                <?php
                $sql = "SELECT id, name, description, price, image FROM menu";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="menu-item">';
                        echo '<img src="bin/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["name"]) . '">';
                        echo '<div class="item-header">';
                        echo '<span class="item-name">' . htmlspecialchars($row["name"]) . '</span>';
                        echo '<span class="item-price">$' . number_format($row["price"], 2) . '</span>';
                        echo '</div>';
                        echo '<p class="item-desc">' . htmlspecialchars($row["description"]) . '</p>';
                        echo '<span class="item-select">Quantity: ';
                        selectQuan($row["id"]);
                        echo '</span>';
                        echo '</div>';
                    }
                } else {
                    echo "0 results in menu";
                }
                $conn->close();
                ?>
            </div>

            <div class="customer-info">
                <h2>Your Information</h2>
                <div id="error-message" style="display: none;"></div>
                
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name">
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name">
                </div>

                <div class="form-group">
                    <label for="special_instructions">Special Instructions:</label>
                    <textarea id="special_instructions" name="special_instructions"></textarea>
                </div>

                <input type="hidden" id="pickup_time" name="pickup_time" value="">

                <input type="submit" value="Submit Order" class="submit-btn">
            </div>

        </form>
    </div>

    <script>
        document.getElementById('orderForm').addEventListener('submit', function(event) {
            
            let firstName = document.getElementById('first_name').value;
            let lastName = document.getElementById('last_name').value;
            let errorMessage = document.getElementById('error-message');
            let errors = [];

            if (firstName.trim() === '' || lastName.trim() === '') {
                errors.push("First and last name are required.");
            }

            let selects = document.querySelectorAll('select[name^="item_"]');
            let totalItems = 0;
            selects.forEach(function(select) {
                totalItems += parseInt(select.value, 10);
            });

            if (totalItems === 0) {
                errors.push("You must order at least one item.");
            }

            if (errors.length > 0) {
                event.preventDefault();
                errorMessage.innerHTML = errors.join('<br>');
                errorMessage.style.display = 'block';
            } else {
                errorMessage.style.display = 'none';
                
                let pickupDate = new Date();
                pickupDate.setMinutes(pickupDate.getMinutes() + 20);
                
                let hours = pickupDate.getHours();
                let minutes = pickupDate.getMinutes();
                let ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12; 
                minutes = minutes < 10 ? '0' + minutes : minutes;
                let pickupString = hours + ':' + minutes + ' ' + ampm;

                document.getElementById('pickup_time').value = pickupString;
            }
        });
    </script>

</body>
</html>