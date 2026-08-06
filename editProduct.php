<?php

require 'conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $projectId = $_POST["product_id"];
    $name = $_POST["name"];
    $category = $_POST["category"];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $result = $conn->query("SELECT image FROM products WHERE id = '$projectId'");
    $row = $result->fetch_assoc();
    $imgPath = $row['image'];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        $targetDir = "images/products/";
        $extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        $newFileName = uniqid() . "." . $extension;
        $targetFile = $targetDir . $newFileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            if (!empty($imgPath) && file_exists($imgPath)) {
                unlink($imgPath);
            }

            $imgPath = $targetFile;
        }
    }

    if (!empty($imgPath)) {
        $sql = "UPDATE products
            SET name='$name',
                price='$price',
                category='$category',
                quantity='$quantity',
                image='$imgPath'
            WHERE id='$projectId'";
    } else {
        $sql = "UPDATE products
            SET name='$name',
                price='$price',
                category='$category',
                quantity='$quantity'
            WHERE id='$projectId'";
    }
    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        exit;
    } else {
        echo $conn->error;
    }
}

?>