<?php
require_once 'conn.php';
session_start();
$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $sql = "DELETE FROM cart WHERE product_id = '$product_id' AND user_id= '$user_id'";
    // echo $sql;
    if ($conn->query($sql) === TRUE) {
        echo 'success'; //redirect url

    } else {
        echo "" . $conn->error;
    }
}
?>