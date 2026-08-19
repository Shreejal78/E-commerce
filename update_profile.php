<?php
require_once 'conn.php';
session_start();
$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $sql = "UPDATE `users` SET `name`='$name',`email`='$email',`password`='$password',`phone`='$phone',`address`='$address' WHERE id='$user_id'";
    // echo $sql;
    if ($conn->query($sql) === TRUE) {
        header('location: profile.php'); //redirect url

    } else {
        echo "" . $conn->error;
    }
}
?>