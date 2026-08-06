<?php
session_start();
?>
<header>

    <div class="logo" onclick="window.location.href = 'index.php';">MyShop</div>

    <nav>
        <a href="index.php">Home</a>
        <?php
                require_once 'conn.php';

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
        ?>
        <a href="#" id="categoryBtn">Category</a>
        <?php
        if (!isset($_SESSION['user_id'])) {
            ?>
            <a href="#" id="loginBtn" style="color:lime;">Login</a>
            <?php
        } else {
            ?>
            <a href="logout.php" style="color:#ed0000;">Log out</a>
            <?php
        }
        ?>
        <div class="categoryBox">
            <p class="categoryOption" data-category="all">All</p>
            <p class="categoryOption" data-category="phone">Mobiles</p>
            <p class="categoryOption" data-category="laptop">Laptops</p>
        </div>
    </nav>

</header>