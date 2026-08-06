<?php

require 'conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        // Image upload
        $targetDir = "images/products/";
        $extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        $newFileName = uniqid() . "." . $extension;
        $targetFile = $targetDir . $newFileName;

        // Move uploaded file
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

        // This is what gets stored in the DB
        $img = $targetFile;

        $sql = "INSERT INTO products (name, price, quantity,category,image) VALUES ('$name', '$price', '$quantity', '$category', '$img')";
        if ($conn->query($sql) == TRUE) {
            echo 'insert Done';
            header('Location: admin.php');
        }else{
            echo 'error';
        }
    }else{
        echo 'error hrererere firsttttt';
    }
}
?>