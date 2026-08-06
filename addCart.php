<?php
require_once 'conn.php';
session_start();
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];
    $total = $_GET['total'];
    $stock = $conn->query("SELECT quantity FROM products WHERE id = $product_id")->fetch_assoc()['quantity'];
    $result = $conn->query("SELECT * FROM cart WHERE product_id = '$product_id' AND user_id='$user_id'");
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO `cart`(`product_id`, `user_id`, `quantity`, `total_price`) VALUES ('$product_id','$user_id','$quantity','$total')";
    } else {
        $storedPrice;
        $storedQuantity;
        while ($row = $result->fetch_assoc()) {
            $storedQuantity = $row['quantity'];
            $storedPrice = $row['total_price'];
        }
        $newQuantity = (int) $storedQuantity + $quantity;
        if($newQuantity > $stock) {
            echo 'excessAmount';
            return;
        };
        $newPrice = (int) $storedPrice + $total;
        $sql = "UPDATE cart SET quantity='$newQuantity' ,total_price='$newPrice' WHERE product_id = '$product_id' AND user_id= '$user_id'";
    }


    // echo $sql;
    if ($conn->query($sql) === TRUE) {
        echo 'success'; //redirect url

    } else {
        echo "" . $conn->error;
    }
}
?>