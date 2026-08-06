<?php
require_once 'conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO `users`(name, password, email, phone, address) VALUES ('$name','$pass','$email','$phone','$address')";

    // echo $sql;
    if ($conn->query($sql) === TRUE) {
        header('location: index.php'); //redirect url

    } else {
        echo "" . $conn->error;
    }
}
?>