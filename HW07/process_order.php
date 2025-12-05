<?php
$servername = "localhost";
$username = "upwi4zp6hjp2s";
$password = "wonkypassword";
$dbname = "dbkqjfku1aachq";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tax_rate = 0.0625;
$subtotal = 0;
$order_items_html = "";
$items_to_save = array();

foreach ($_GET as $key => $value) {
    if (strpos($key, 'item_') === 0 && $value > 0) {
        $id = substr($key, 5);
        $quantity = intval($value);

        $sql = "SELECT name, price FROM menu WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $price = $row['price'];
            $item_total = $price * $quantity;
            $subtotal += $item_total;

            $order_items_html .= "<div class='order-item'>";
            $order_items_html .= "<h3>" . htmlspecialchars($name) . "</h3>";
            $order_items_html .= "<p>Quantity: $quantity</p>";
            $order_items_html .= "<p>Price: $" . number_format($price, 2) . "</p>";
            $order_items_html .= "<p class='item-total'>Item Total: $" . number_format($item_total, 2) . "</p>";
            $order_items_html .= "</div>";
            
            $items_to_save[] = array("name" => $name, "quantity" => $quantity);
        }
        $stmt->close();
    }
}

$tax = $subtotal * $tax_rate;
$total = $subtotal + $tax;

$first_name = htmlspecialchars($_GET['first_name'] ?? '');
$last_name = htmlspecialchars($_GET['last_name'] ?? '');
$customer_name = $first_name . ' ' . $last_name;
$special_instructions = htmlspecialchars($_GET['special_instructions'] ?? '');
$pickup_time = htmlspecialchars($_GET['pickup_time'] ?? 'ASAP');

if (count($items_to_save) > 0) {
    $sql_order = "INSERT INTO orders (OrderTime, CustomerName, SpecialInstructions) VALUES (DATE_SUB(NOW(), INTERVAL 5 HOUR), ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("ss", $customer_name, $special_instructions);
    $stmt_order->execute();
    $new_order_id = $conn->insert_id;
    $stmt_order->close();

    $sql_item = "INSERT INTO order_items (OrderID, ItemName, Quantity) VALUES (?, ?, ?)";
    $stmt_item = $conn->prepare($sql_item);

    foreach ($items_to_save as $item) {
        $stmt_item->bind_param("isi", $new_order_id, $item['name'], $item['quantity']);
        $stmt_item->execute();
    }
    $stmt_item->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>The Mynock-Bite Diner - Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            border-bottom: 2px solid #eeda4a;
            padding-bottom: 10px;
        }
        .order-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .order-item h3 {
            margin: 0;
            color: #1a1a1a;
        }
        .order-item p {
            margin: 5px 0;
        }
        .item-total {
            font-weight: bold;
        }
        .summary-box {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #eeda4a;
        }
        .summary-line {
            display: flex;
            justify-content: space-between;
            font-size: 1.2em;
            margin: 10px 0;
        }
        .total {
            font-weight: bold;
            font-size: 1.4em;
            color: #008000;
        }
        .customer-details {
            margin-top: 20px;
        }
        .customer-details p {
            margin: 5px 0;
        }
        .pickup-time {
            font-size: 1.3em;
            font-weight: bold;
            color: #ff4500;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Thanks for your order, <?php echo $first_name; ?>!</h2>
        
        <div class="order-summary">
            <?php echo $order_items_html; ?>
        </div>

        <div class="summary-box">
            <div class="summary-line">
                <span>Subtotal:</span>
                <span>$<?php echo number_format($subtotal, 2); ?></span>
            </div>
            <div class="summary-line">
                <span>Tax (6.25%):</span>
                <span>$<?php echo number_format($tax, 2); ?></span>
            </div>
            <div class="summary-line total">
                <span>Total:</span>
                <span>$<?php echo number_format($total, 2); ?></span>
            </div>
        </div>

        <div class="pickup-time">
            Pickup Time: <?php echo $pickup_time; ?>
        </div>

        <div class="customer-details">
            <h2>Order Details</h2>
            <p><strong>Name:</strong> <?php echo $customer_name; ?></p>
            <p><strong>Special Instructions:</strong> <?php echo nl2br($special_instructions); ?></p>
        </div>
    </div>

</body>
</html>