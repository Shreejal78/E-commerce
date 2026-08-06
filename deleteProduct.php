<?php
require_once 'conn.php';
session_start();
if (!isset($_SESSION['is_admin'])) {
    header('location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = (int)$_POST['product_id'];

    // Get image path
    $result = $conn->query("SELECT image FROM products WHERE id = $product_id");

    if ($result && $result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $imgPath = $row["image"];

        // Delete image file if it exists
        if (!empty($imgPath) && file_exists($imgPath)) {
            unlink($imgPath);
        }

        // Delete project from database
        $sql = "DELETE FROM products WHERE id = $product_id";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo $conn->error;
        }

    } else {
        echo "Project not found.";
    }
}
?>