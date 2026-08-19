<?php
require_once 'conn.php';
session_start();
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "SELECT * FROM cart WHERE user_id='$user_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $total = $row['total_price'];
        $deleteCartsql = "DELETE FROM `cart` WHERE product_id='$product_id'";
        $insertsql = "INSERT INTO `orders`(`product_id`, `user_id`, `quantity`, `total_price`) VALUES ($product_id,$user_id,$quantity,$total)";
        if ($conn->query($insertsql) === TRUE && $conn->query($deleteCartsql) === TRUE ) {
            $response = ['success' => true];
        }else{
            $response = ['success' => false];
        }
    }


}

header("Content-Type: application/json");
echo json_encode($response);
// var_dump($tasks)
?>