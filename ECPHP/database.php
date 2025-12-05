<?php
    $servername = "localhost";
    $username = "upwi4zp6hjp2s";
    $pw = "wonkypassword";
    $database = "dbkqjfku1aachq";

$conn = new mysqli($servername, $username, $pw, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `Car Name`, Description, Price, ImageURL FROM Cars";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Database Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .product-card {
            flex-basis: 45%;
            min-width: 300px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .product-header {
            font-size: 1.2em;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .product-price {
            color: #008000;
        }
        .product-description {
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="product-grid">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                
                echo '<img src="' . htmlspecialchars($row["ImageURL"]) . '" alt="' . htmlspecialchars($row["Car Name"]) . '" class="product-image">';
                
                echo '<div class="product-header">';
                echo '<span class="product-name">' . htmlspecialchars($row["Car Name"]) . '</span>';
                echo '<span class="product-price">$' . number_format($row["Price"], 2) . '</span>';
                echo '</div>';
                
                echo '<p class="product-description">' . htmlspecialchars($row["Description"]) . '</p>';
                
                echo '</div>';
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>

</body>
</html>