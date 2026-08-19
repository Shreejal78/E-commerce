<?php
session_start();
?>
<header>

    <div class="logo" onclick="window.location.href = 'index.php';">MyShop</div>
    <div class="searchBar">
        <input type="search" name="search" id="search" placeholder="Search Item">
        <button type="submit" id="searchBtn">search</button>
    </div>
    <nav>
        <a href="index.php">Home</a>
        <?php
        require_once 'conn.php';
        if (!isset($_SESSION['is_admin'])) {

            if (!isset($_SESSION['user_id'])) {
                ?>
                <a href="cart.php" id="cartBtn">🛒 Cart</a>
                <?php
            } else {
                $user_id = $_SESSION['user_id'];
                $result = $conn->query("SELECT * FROM cart where user_id='$user_id'");
                if ($result->num_rows == 0) {
                    ?>
                    <a href="cart.php" id="cartBtn">🛒 Cart</a>
                    <?php
                } else {
                    ?>
                    <a href="cart.php" id="cartBtn">🛒 Cart<span id="noti"><?= $result->num_rows; ?></span></a>
                    <?php
                }
            }
        }
        ?>
        <?php
        if (!isset($_SESSION['user_id'])) {
            ?>
            <a href="#" id="loginBtn" style="color:lime;">Login</a>
            <?php
        } else {
            ?>
            <?php if (!isset($_SESSION['is_admin'])) {
                ?>
                <a href="profile.php">Profile</a>
                <?php
            }else{
                ?>
                <a href="admin.php">Dashboard</a>

                <?php

            }
            ?>
            <a href="logout.php" style="color:#ed0000;">Log out</a>
            <?php
        }
        ?>

    </nav>

</header>