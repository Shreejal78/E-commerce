<?php

function getStock($product_id)
{
    require_once 'conn.php';
    $sql = "SELECT quantity FROM products where id='$product_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        return $row['skills'];
    }
}

$conn->close();
?>