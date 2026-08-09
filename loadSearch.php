<?php
require_once 'conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serach = $_POST['search'];
    $sql = "SELECT * FROM products where name LIKE '%$serach%'";
    $result = $conn->query($sql);
    $product = [];
    while ($row = $result->fetch_assoc()) {
        $product[] = $row;
    }
}
header("Content-Type: application/json");
echo json_encode($product);
?>