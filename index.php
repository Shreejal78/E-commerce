<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="style-dark.css">
</head>

<body>

    <?php include_once 'navBar.php'; ?>
    <?php include_once 'loginPopUp.php'; ?>
    <div class="categoryBox">
        <p class="categoryOption" data-category="all">All</p>
        <p class="categoryOption" data-category="phone">Mobiles</p>
        <p class="categoryOption" data-category="laptop">Laptops</p>
    </div>
    
    <main>

        <h1>Featured Products</h1>

        <div class="products" id="products">

            <?php
            require_once 'conn.php';
            $sql = 'SELECT * FROM products';
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card" onclick="location.href='product.php?product_id=<?php echo $row['id']; ?>'">
                    <img src="<?= $row['image']; ?>" alt="" loading="lazy">
                    <div class="card-content">
                        <h2><?php echo $row['name']; ?></h2>
                        <div class="price"><?php echo '$' . $row['price']; ?></div>
                        <button onclick="location.href='product.php?product_id=<?php echo $row['id']; ?>'">
                            View Product
                        </button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

    </main>

    <script src="script.js"></script>

</body>

</html>