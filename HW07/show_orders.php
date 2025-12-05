<?php
$servername = "localhost";
$username = "upwi4zp6hjp2s";
$password = "wonkypassword";
$dbname = "dbkqjfku1aachq";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT 
            o.OrderID, 
            o.OrderTime, 
            o.CustomerName, 
            o.SpecialInstructions, 
            oi.ItemName, 
            oi.Quantity 
        FROM orders o
        JOIN order_items oi ON o.OrderID = oi.OrderID 
        ORDER BY o.OrderTime DESC, o.OrderID, oi.ItemName";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>The Mynock-Bite Diner - All Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 900px;
            margin: 20px auto;
        }
        .order-block {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .order-header {
            background-color: #f9f9f9;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            border-radius: 8px 8px 0 0;
        }
        .order-header h2 {
            margin: 0;
            color: #333;
        }
        .order-header span {
            font-size: 0.9em;
            color: #777;
        }
        .order-body {
            padding: 20px;
        }
        .order-body strong {
            color: #555;
        }
        .order-items {
            list-style: none;
            padding-left: 0;
            margin-top: 15px;
            border-top: 1px dashed #ccc;
            padding-top: 15px;
        }
        .order-items li {
            padding: 5px 0;
            display: flex;
            justify-content: space-between;
        }
        .item-name {
            font-weight: bold;
        }
        .item-qty {
            color: #008000;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <?php
        $current_order_id = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                if ($row['OrderID'] != $current_order_id) {
                    if ($current_order_id != 0) {
                        echo '</ul></div></div>'; 
                    }
                    $current_order_id = $row['OrderID'];
                    
                    echo '<div class="order-block">';
                    echo '<div class="order-header">';
                    echo '<h2>Order ID: ' . $row['OrderID'] . ' - ' . htmlspecialchars($row['CustomerName']) . '</h2>';
                    echo '<span>' . date("M j, Y g:ia", strtotime($row['OrderTime'])) . '</span>';
                    echo '</div>';
                    echo '<div class="order-body">';
                    echo '<p><strong>Instructions:</strong> ' . (empty($row['SpecialInstructions']) ? 'None' : nl2br(htmlspecialchars($row['SpecialInstructions']))) . '</p>';
                    echo '<ul class="order-items">';
                }
                
                echo '<li>';
                echo '<span class="item-name">' . htmlspecialchars($row['ItemName']) . '</span>';
                echo '<span class="item-qty">Quantity: ' . $row['Quantity'] . '</span>';
                echo '</li>';
            }
            echo '</ul></div></div>';
        } else {
            echo "<h2>No orders found.</h2>";
        }
        $conn->close();
        ?>
    </div>

</body>
</html>