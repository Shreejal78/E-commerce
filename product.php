<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>

    <link rel="stylesheet" href="style-dark.css">
</head>

<body>

    <?php include_once 'navBar.php'; ?>
    <?php include_once 'loginPopUp.php'; ?>
    <div id="addCartAlert">
        Added to cart successfully!
    </div>
    <main>
        <div class="product-page">
            <?php
            require_once 'conn.php';
            $isadmin = $_SESSION['is_admin'];
            $product_id = $_GET['product_id'];
            $sql = "SELECT * FROM products WHERE id=$product_id";
            $result = $conn->query($sql);
            $inStockQuantity;
            $price;
            while ($row = $result->fetch_assoc()) {
                $inStockQuantity = $row['quantity'];
                $price = $row['price'];
                ?>
                <div class="product-image">
                    <img id="productImage" src="<?= $row['image']; ?>" alt="">
                </div>
                <div class="product-info">
                    <h1 id="productName"><?php echo $row['name']; ?></h1>
                    <p id="productDescription">Description: NOT WRITTEN</p>
                    <p class="stock">On Stock: <span><?= $row['quantity']; ?></span></p>
                    <div class="price" id="productPrice"><?php echo '$' . $price; ?></div>
                    <h3>Quantity</h3>
                    <div class="quantity-box">
                        <button id="minus" class="inCart">−</button>
                        <span id="quantity">1</span>
                        <button id="plus" class="inCart">+</button>
                    </div>
                    <?php
                    if (!$isadmin) {
                        ?>
                        <div class="total">
                            Total: <span id="totalPrice"></span>
                        </div>

                        <button class="add-cart inCart" id="addCart">
                            🛒 Add to Cart
                        </button>

                    </div>
                    <?php
                    }
                    ?>
                <?php
            }
            ?>
        </div>

    </main>
    <script>
        let min = document.getElementById('minus');
        let plus = document.getElementById('plus');
        let total = document.getElementById('totalPrice');
        let quantity = document.getElementById('quantity');
        min.addEventListener('click', () => {
            if (quantity.innerText == 1) return;
            quantity.innerText--
            total.innerText = calcTotal(quantity.innerText)
        })
        function calcTotal(quan) {
            return quan * <?php echo $price; ?>;
        }
        plus.addEventListener('click', () => {
            if (quantity.innerText >= <?php echo $inStockQuantity; ?>) return;
            quantity.innerText++
            total.innerText = calcTotal(quantity.innerText)

        })
        total.innerText = calcTotal(quantity.innerText)
        document.getElementById('addCart').addEventListener('click', async (e) => {
            const loginStatus = await fetch('checkLogin.php').then(res => res.text());

            if (loginStatus === 'userNotLoggedIn') {
                e.preventDefault();
                let urls = document.querySelectorAll('.url');
                document.querySelector(".popup").style.display = "flex";
                const params = new URLSearchParams(window.location.search).get('product_id');

                urls.forEach(url => {
                    url.value = params;
                })
                return;
            }

            const data = await fetch(
                `addCart.php?product_id=<?php echo $product_id; ?>&quantity=${quantity.innerText}&total=${total.innerText}`
            ).then(res => res.text());

            console.log(data);

            if (data === 'success') {
                showToast("Added to cart successfully!");

            } else if (data === 'excessAmount') {
                document.querySelectorAll('.inCart').forEach(btn => {
                    btn.disabled = true;
                });
                e.target.innerText = '🚫 Exceed Stock Limits';
                alert('out of stock')
            }
        });


        const alertBox = document.querySelector("#addCartAlert");

        function showToast(message) {
            alertBox.textContent = message;
            alertBox.classList.add("show");

            setTimeout(() => {
                alertBox.classList.remove("show");
            }, 2000);
        }

    </script>

</body>

</html>