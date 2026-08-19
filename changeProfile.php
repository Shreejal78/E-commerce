<?php

require 'conn.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_SESSION['user_id'];

    $result = $conn->query("SELECT image FROM users WHERE id = '$user_id'");
    $row = $result->fetch_assoc();

    $imgPath = $row['image'];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        $targetDir = "images/users/";
        $extension = strtolower(
            pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION)
        );

        $newFileName = uniqid() . "." . $extension;
        $targetFile = $targetDir . $newFileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            if (!empty($imgPath) && file_exists($imgPath)) {
                unlink($imgPath);
            }

            $imgPath = $targetFile;
            $sql = "UPDATE users
                    SET image='$imgPath'
                    WHERE id='$user_id'";

            if ($conn->query($sql) === TRUE) {

                echo json_encode([
                    'success' => true,
                    'newPath' => $imgPath
                ]);

            } else {

                echo json_encode([
                    'success' => false
                ]);
            }

        } else {

            echo json_encode([
                'success' => false
            ]);
        }
    }
}
?>