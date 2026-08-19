
<?php require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <link rel="stylesheet" href="style-dark.css">
</head>

<body>

    <?php include_once 'navBar.php'; ?>
    <?php include_once 'loginPopUp.php'; ?>

    <main>

        <h1>Shopping Cart</h1>

        <div class="cart-container">

            <div class="cart-items" id="cartItems">

                <?php
                if (!isset($_SESSION['user_id'])) {
                    //redirect url
                    ?>
                    <div class="empty-cart">
                        <h2>Your cart is empty.</h2>
                        <p>Add some products to get started.</p>
                    </div>
                    <?php
                    exit;

                }
                require_once 'conn.php';
                $sql = "SELECT
    cart.*,
    products.*,
    cart.quantity AS cart_quantity,products.quantity AS stock_quantity,products.image AS product_img FROM cart
INNER JOIN products
ON cart.product_id = products.id
WHERE cart.user_id ='$user_id'";
                $cartEmpty;
                $result = $conn->query($sql);
                if ($result->num_rows == 0) {
                    $cartEmpty = true;
                    ?>
                    <div class="empty-cart">
                        <h2>Your cart is empty.</h2>
                        <p>Add some products to get started.</p>
                    </div>
                    <?php
                } else {
                    $cartEmpty = false;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="cart-item" data-id="<?= $row['product_id'] ?>">
                            <img src="<?= $row['product_img']; ?>" alt="Not Load">

                            <div class="cart-info">
                                <h3><?= htmlspecialchars($row['name']) ?></h3>

                                <div class="cart-price">
                                    $ <span class="price">
                                        <?= number_format($row['price'], 2) ?>
                                    </span>
                                </div>
                                <p style="margin:0 0 10px 0;">In Stock: <span class="stock"><?= $row['stock_quantity'] ?></span>
                                </p>
                                <div class="cart-controls">
                                    <button class="minus-btn">−</button>

                                    <span class="product-quantity"><?= $row['cart_quantity'] ?></span>

                                    <button class="plus-btn">+</button>
                                </div>

                                <button class="remove-btn">
                                    Remove
                                </button>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
<?php if(!$cartEmpty){
    ?>
            <div class="cart-summary">

                <h2>Order Summary</h2>

                <div class="summary-row">
                    <span>Items</span>
                    <span id="itemCount">0</span>
                </div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotal">$0.00</span>
                </div>

                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>

                <hr>

                <div class="summary-row total-row">
                    <span>Total</span>
                    <span id="total">$0.00</span>
                </div>

                <button class="checkout-btn" onclick="window.location.href = 'payment.php'">
                    Checkout
                </button>

            </div>
            <?php
}
?>
        </div>

    </main>
    <script>
        let plusBtns = document.querySelectorAll('.plus-btn');
        let removeBtn = document.querySelectorAll('.remove-btn');
        let minusBtns = document.querySelectorAll('.minus-btn');
        plusBtns.forEach(btn => {
            let parent = btn.closest('.cart-item');
            let cartQuantity = parent.querySelector('.product-quantity');
            let stockQuantity = parent.querySelector('.stock');
            btn.addEventListener('click', async (e) => {
                let minusBtn = parent.querySelector('.minus-btn');
                let price = parseFloat(parent.querySelector('.price').innerText)
                cartQuantity.innerText++;
                let total = parseInt(cartQuantity.innerText) * price;

                fetch("changeQuantity.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `product_id=${parent.dataset.id}&quantity=${cartQuantity.innerText}&total=${total}`
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            calculateTotal();

                        } else {
                            console.error(data);
                        }
                    })
                    .catch(error => console.error('Error:', error))
                minusBtn.disabled = false; // Enable minus once quantity > 1
                btn.disabled = parseInt(cartQuantity.innerText) >= parseInt(stockQuantity.innerText);
            });
            btn.disabled = parseInt(cartQuantity.innerText) >= parseInt(stockQuantity.innerText);
        });


        minusBtns.forEach(btn => {
            let parent = btn.closest('.cart-item');
            let cartQuantity = parent.querySelector('.product-quantity');
            let stockQuantity = parent.querySelector('.stock');
            btn.addEventListener('click', (e) => {
                let plusBtn = parent.querySelector('.plus-btn');
                let price = parseFloat(parent.querySelector('.price').innerText)
                cartQuantity.innerText--;
                let total = parseInt(cartQuantity.innerText) * price;

                fetch("changeQuantity.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `product_id=${parent.dataset.id}&quantity=${cartQuantity.innerText}&total=${total}`
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            calculateTotal();

                        } else {
                            console.error(data);
                        }
                    })
                    .catch(error => console.error('Error:', error))
                plusBtn.disabled = false; // Re-enable plus when quantity decreases
                btn.disabled = parseInt(cartQuantity.innerText) <= 1;
            });
            btn.disabled = parseInt(cartQuantity.innerText) <= 1;
        });

        removeBtn.forEach(btn => {
            let parent = btn.closest('.cart-item');
            btn.addEventListener('click', async () => {
                console.log('startt')
                fetch("deleteCart.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `product_id=${parent.dataset.id}`
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            parent.remove();
                            calculateTotal();
                        } else {
                            console.error(data);
                        }
                    })
                    .catch(error => console.error('Error:', error))
            })
        });
        async function calculateTotal() {
            let itemCount = document.getElementById('itemCount');
            let subtotal = document.getElementById('subtotal');
            let total = document.getElementById('total');

            let res = await fetch('itemCount.php');
            let item_total = await res.json();
            itemCount.innerText = item_total.totalItem;
            subtotal.innerText = '$' + item_total.totalPrice;
            total.innerText = '$' + item_total.totalPrice;
        }
        calculateTotal();
    </script>

</body>

</html>