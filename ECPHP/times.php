<!DOCTYPE html>
<html>
<head>
    <title>Times Table</title>
</head>
<body>

<?php
if (isset($_GET['n'])) {
    $n = $_GET['n'];
    
    for ($i = 1; $i <= 15; $i++) {
        $result = $i * $n;
        echo "$i x $n = $result<br>";
    }
} else {
    echo "Please provide a number in the URL (e.g., times.php?n=5)";
}
?>

</body>
</html>