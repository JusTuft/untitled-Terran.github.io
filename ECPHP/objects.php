<?php
class Product {
    public $name;
    public $description;
    public $price;

    public function __construct($name, $description, $price) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
}

$products = array(
    new Product("2019 Subaru WRX", "A modern AWD sedan with rally heritage. My car!", 24998),
    new Product("2020 Porsche 911 Carrera", "The iconic German rear-engine sports car.", 115000),
    new Product("1980 Chevrolet Camaro Z28", "A classic American muscle car with a V8.", 28000),
    new Product("1995 Toyota Supra Turbo", "A legendary JDM sports car with a 2JZ engine.", 95000),
    new Product("2020 Ford Mustang GT", "The modern American muscle car with a 5.0L V8.", 32998),
    new Product("2020 Toyota GR Supra", "The fifth-generation Supra, a modern JDM coupe.", 49123),
    new Product("2019 BMW M4", "A high-performance German coupe.", 46998),
    new Product("1998 Nissan Skyline GT-R", "A legendary JDM car, known as 'Godzilla'.", 125000)
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Display</title>
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
        foreach ($products as $product) {
            echo '<div class="product-card">';
            echo '<div class="product-header">';
            echo '<span class="product-name">' . htmlspecialchars($product->name) . '</span>';
            echo '<span class="product-price">$' . number_format($product->price, 2) . '</span>';
            echo '</div>';
            echo '<p class="product-description">' . htmlspecialchars($product->description) . '</p>';
            echo '</div>';
        }
        ?>
    </div>

</body>
</html>