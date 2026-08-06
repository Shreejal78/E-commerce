<?php
require_once 'conn.php';
session_start();
$user_id = $_SESSION['user_id'];
$totalItem = [];
$total = [];
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT * FROM cart WHERE user_id='$user_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $total[] = $row['total_price'];
        $totalItem[] = $row['quantity'];
    }

}

$response = [
    'totalItem' => array_sum($totalItem),
    'totalPrice' => array_sum($total)
];

header("Content-Type: application/json");
echo json_encode($response);
// var_dump($tasks)
?>