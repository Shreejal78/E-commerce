<?php
require_once 'conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    if ($category == 'all') {
        $sql = "SELECT * FROM products";
    } else {
        $sql = "SELECT * FROM products where category='$category'";

    }
    $result = $conn->query($sql);
    $product = [];
    while ($row = $result->fetch_assoc()) {
        $product[] = $row;
    }
}
header("Content-Type: application/json");
echo json_encode($product);
?>