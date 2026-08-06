<?php

require_once 'conn.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST);
    $pass = $_POST['password'];
    $product_id = $_POST['currentUrl'];
    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    $result = $conn->query($sql);
    var_dump($result);
    if ($result->num_rows == 1) {
        echo 'skjdf';
        while ($row = $result->fetch_assoc()) {
            $_SESSION['user_id'] = $row['id'];
            if ($row['isadmin'] == 1) {
                $_SESSION['is_admin'] = true;
                header("location: admin.php");
                exit;
            }
            if (isset($product_id)) {
                header("location: product.php?product_id=$product_id"); //redirect url
            }else{
                header('location: index.php');
            }
        }

    } else {
        echo 'Incorrect Username OR Password.'; //redirect url
    }
}
?>