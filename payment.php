<?php require_once 'auth.php'; ?>

<?php
require_once("conn.php");
session_start();

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM users WHERE id='$user_id'";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $user_name = $row['name'];
    $user_address = $row['address'];
    $user_phone = $row['phone'];
    $user_email = $row['email'];
    $user_password = $row['password'];
    $user_profile = $row['image'] ?? 'images\users\default.png';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Secure Checkout</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background: #f5f7fb;
            color: #172033;
            min-height: 100vh;
        }

        .checkout-container {
            max-width: 1150px;
            margin: auto;
            padding: 40px 20px;
        }


        /* HEADER */

        .checkout-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .checkout-header h1 {
            font-size: 30px;
            margin-bottom: 5px;
        }

        .checkout-header p {
            color: #6b7280;
        }

        .secure-badge {
            background: #eaf8ef;
            color: #178344;
            padding: 10px 16px;
            border-radius: 30px;
            font-weight: 700;
        }


        /* GRID */

        .checkout-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 25px;
            align-items: start;
        }


        /* CARDS */

        .checkout-card,
        .order-card {
            background: white;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(20, 30, 50, 0.07);
        }

        .checkout-card h2,
        .order-card h2 {
            margin-bottom: 20px;
        }


        /* PAYMENT METHODS */

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }

        .method {
            border: 2px solid #e5e7eb;
            background: white;
            padding: 15px;
            border-radius: 12px;
            display: flex;
            gap: 12px;
            align-items: center;
            cursor: pointer;
            text-align: left;
            transition: .2s;
        }

        .method:hover {
            border-color: #aeb7c7;
        }

        .method.active {
            border-color: #5b4bff;
            background: #f7f5ff;
        }

        .method span:first-child {
            font-size: 25px;
        }

        .method strong {
            display: block;
            margin-bottom: 3px;
        }

        .method small {
            color: #737b8c;
        }


        /* WALLET LOGOS */

        .wallet-logo {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            color: white;
            font-weight: 900;
        }

        .esewa {
            background: #43a047;
        }

        .khalti {
            background: #5d2ba8;
        }

        .fonepay {
            background: #e53935;
        }


        /* PAYMENT PANEL */

        .payment-panel {
            border-top: 1px solid #eee;
            padding-top: 25px;
        }

        .hidden {
            display: none !important;
        }


        /* CARD BRANDS */

        .card-brands {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .visa {
            font-style: italic;
            font-weight: 900;
            color: #1434cb;
            font-size: 21px;
        }

        .mastercard {
            display: flex;
            align-items: center;
        }

        .mastercard i {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: block;
        }

        .mastercard i:first-child {
            background: #eb001b;
            margin-right: -8px;
        }

        .mastercard i:last-child {
            background: #f79e1b;
        }


        /* FORMS */

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #d9dee8;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
            transition: .2s;
        }

        input:focus {
            border-color: #5b4bff;
            box-shadow: 0 0 0 3px rgba(91, 75, 255, .1);
        }

        .card-input {
            position: relative;
        }

        .card-input input {
            padding-right: 50px;
        }

        .card-input span {
            position: absolute;
            right: 15px;
            top: 13px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }


        /* SECURITY */

        .security-message {
            background: #f1f8f4;
            color: #267448;
            border-radius: 9px;
            padding: 12px;
            font-size: 13px;
        }


        /* BILLING */

        .billing {
            border-top: 1px solid #eee;
            margin-top: 25px;
            padding-top: 25px;
        }


        /* WALLET */

        .wallet-message {
            text-align: center;
            padding: 25px 10px;
        }

        .large-wallet-icon {
            margin: auto auto 15px;
            width: 65px;
            height: 65px;
            border-radius: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #ffc400;
            color: white;
            font-size: 32px;
            font-weight: bold;
        }

        .wallet-message p {
            color: #6b7280;
            margin-top: 8px;
        }


        /* ORDER */

        .order-card {
            position: sticky;
            top: 20px;
        }

        .order-item {
            display: grid;
            grid-template-columns: 55px 1fr auto;
            align-items: center;
            gap: 12px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .product-image {
            width: 55px;
            height: 55px;
            border-radius: 10px;
            background: #f1f3f7;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 25px;
        }

        .product-info strong,
        .product-info span {
            display: block;
        }

        .product-info span {
            color: #737b8c;
            font-size: 13px;
            margin-top: 5px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            color: #646b79;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #eee;
            margin-top: 8px;
            padding-top: 18px;
            font-size: 20px;
        }


        /* PAY BUTTON */

        .pay-button {
            width: 100%;
            margin-top: 25px;
            padding: 16px;
            border: 0;
            border-radius: 11px;
            background: #5b4bff;
            color: white;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s;
        }

        .pay-button:hover {
            background: #4938e8;
        }

        .pay-button:disabled {
            opacity: .6;
            cursor: not-allowed;
        }


        /* TRUST */

        .trust {
            text-align: center;
            color: #687183;
            font-size: 12px;
            line-height: 2;
            margin-top: 15px;
        }


        /* ERRORS */

        .error-message {
            background: #fff0f0;
            color: #c62828;
            padding: 13px;
            border-radius: 9px;
            margin-top: 15px;
            font-size: 14px;
        }


        /* RESULT */

        .result-screen {
            display: flex;
            flex-direction: column;
            gap:10px;
            background: white;
            max-width: 650px;
            margin: 50px auto;
            padding: 45px;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(20, 30, 50, .08);
        }

        .result-icon {
            width: 75px;
            height: 75px;
            margin: auto auto 20px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            font-weight: bold;
        }

        .success {
            background: #dff7e7;
            color: #1c8a47;
        }

        .failure {
            background: #ffe4e4;
            color: #d32f2f;
        }

        .result-screen h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .result-screen>p {
            color: #687183;
        }

        .confirmation-box {
            background: #f7f8fa;
            border-radius: 12px;
            margin: 25px 0;
            padding: 18px;
            text-align: left;
        }

        .confirmation-box div {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .confirmation-box div:last-child {
            border-bottom: 0;
        }

        .confirmation-box span {
            color: #6b7280;
        }

        .paid {
            color: #ffc60b;
        }

        .confirmation-text {
            margin-bottom: 20px;
        }

        .secondary-button {
            padding: 13px 22px;
            border: 0;
            background: #172033;
            color: white;
            border-radius: 9px;
            cursor: pointer;
            font-weight: 700;
        }

        input[readonly] {
            background: #f8fafc;
            color: #9ca3af;
            cursor: not-allowed;
        }


        /* MOBILE */

        @media (max-width: 800px) {

            .checkout-grid {
                grid-template-columns: 1fr;
            }

            .order-card {
                position: static;
            }

            .payment-methods {
                grid-template-columns: 1fr;
            }

            .checkout-header {
                align-items: flex-start;
                gap: 15px;
            }

        }

        @media (max-width: 500px) {

            .checkout-container {
                padding: 20px 12px;
            }

            .checkout-card,
            .order-card,
            .result-screen {
                padding: 20px;
                border-radius: 14px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

        }
    </style>
</head>

<body>

    <div class="checkout-container">

        <header class="checkout-header">
            <div>
                <h1>Secure Checkout</h1>
                <p>Complete your payment securely</p>
            </div>

            <div class="secure-badge">
                🔒 Secure
            </div>
        </header>

        <main class="checkout-grid">

            <!-- LEFT -->
            <section class="checkout-card">

                <h2>Payment Method</h2>

                <div class="payment-methods">

                    <button class="method active" data-method="cash">
                        <span>💵</span>
                        <div>
                            <strong>Cash on Delivery</strong>
                            <small>Cash Rs.</small>
                        </div>
                    </button>

                    <button class="method" data-method="esewa">
                        <span class="wallet-logo esewa">e</span>
                        <div>
                            <strong>eSewa</strong>
                            <small>Pay with eSewa</small>
                        </div>
                    </button>

                    <button class="method" data-method="khalti">
                        <span class="wallet-logo khalti">K</span>
                        <div>
                            <strong>Khalti</strong>
                            <small>Pay with Khalti</small>
                        </div>
                    </button>

                    <button class="method" data-method="fonepay">
                        <span class="wallet-logo fonepay">F</span>
                        <div>
                            <strong>Fonepay</strong>
                            <small>Pay with Fonepay</small>
                        </div>
                    </button>

                </div>

                <!-- WALLET FORM -->

                <div id="walletPayment" class="payment-panel">

                    <div class="wallet-message">

                        <div id="walletIcon" class="large-wallet-icon">
                            $
                        </div>

                        <h3 id="walletTitle">Cash</h3>

                        <p id="walletDescription">
                            Your item will be soon delivered!
                        </p>

                    </div>

                </div>


                <!-- BILLING -->

                <div class="billing">

                    <h2>Customer Information</h2>

                    <div class="form-group">
                        <label for="customerName">Full Name</label>

                        <input type="text" id="customerName" value="<?php echo $user_name; ?>" readonly>
                    </div>


                    <div class="form-group">
                        <label for="email">Email Address</label>

                        <input type="email" id="email" value="<?php echo $user_email; ?>" readonly>
                    </div>


                    <div class="form-group">
                        <label for="phone">Phone Number</label>

                        <input type="tel" id="phone" value="<?php echo $user_phone; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">Address</label>

                        <input type="tel" id="address" value="<?php echo $user_address; ?>" readonly>
                    </div>

                </div>


                <div id="errorMessage" class="error-message hidden"></div>

            </section>


            <!-- RIGHT -->

            <aside class="order-card">

                <h2>Your Order</h2>
                <div class="total-row">
                    <span>Total</span>
                    <strong>NPR <span class="price">----</span></strong>
                </div>


                <button id="payButton" class="pay-button">
                    🔒 Pay NPR <span class="price">----</span>
                </button>


                <div class="trust">

                    <div>🔒 Secure Checkout</div>
                    <div>✓ Protected Payment</div>
                    <div>✓ Order Confirmation</div>

                </div>

            </aside>

        </main>


        <!-- SUCCESS -->

        <div id="successScreen" class="result-screen hidden">

            <div class="result-icon success">
                ✓
            </div>

            <h2>Order Placed!</h2>

            <p>Your payment has been successfully processed.</p>

            <div class="confirmation-box">


                <div>
                    <span>Payment Method</span>
                    <strong id="successMethod">Card</strong>
                </div>

                <div>
                    <span>Amount</span>
                    <strong>NPR <span class="price">----</span></strong>
                </div>

                <div>
                    <span>Status</span>
                    <strong class="paid">Pending</strong>
                </div>

            </div>

            <p class="confirmation-text">
                A confirmation has been prepared for your order.
            </p>

            <button class="secondary-button" onclick="window.location.href = 'index.php'">
                Continue Shopping
            </button>

        </div>


        <!-- FAILURE -->

        <div id="failureScreen" class="result-screen hidden">

            <div class="result-icon failure">
                !
            </div>

            <h2>Payment Failed</h2>

            <p id="failureReason">
                We could not process your payment.
            </p>

            <button class="secondary-button" id="tryAgain">
                Try Again
            </button>

        </div>

    </div>


    <script type="module">

        async function getTotal() {
            let res = await fetch('itemCount.php');
            return res.json().then(data => data.totalPrice);

        }

        const total = await getTotal();


        let allPrice = document.querySelectorAll('.price');
        allPrice.forEach(el => {
            el.innerHTML = total;
        })


        const methods = document.querySelectorAll(".method");
        const walletPayment = document.getElementById("walletPayment");

        const walletIcon = document.getElementById("walletIcon");
        const walletTitle = document.getElementById("walletTitle");
        const walletDescription = document.getElementById("walletDescription");

        const payButton = document.getElementById("payButton");

        const errorMessage = document.getElementById("errorMessage");

        const successScreen = document.getElementById("successScreen");
        const failureScreen = document.getElementById("failureScreen");

        const successMethod = document.getElementById("successMethod");

        const failureReason = document.getElementById("failureReason");
        const tryAgain = document.getElementById("tryAgain");


        let selectedMethod = "cash";


        /* PAYMENT METHODS */

        methods.forEach(method => {

            method.addEventListener("click", () => {

                methods.forEach(item => {
                    item.classList.remove("active");
                });

                method.classList.add("active");

                selectedMethod = method.dataset.method;

                updatePaymentPanel();

            });

        });


        function updatePaymentPanel() {

            errorMessage.classList.add("hidden");

            walletPayment.classList.remove("hidden");


            const walletData = {
                cash: {
                    title: "Cash",
                    icon: "$",
                    color: "#ffc400",
                    description:
                        "Your item will be soon delivered!"
                },
                esewa: {
                    title: "eSewa",
                    icon: "e",
                    color: "#43a047",
                    description:
                        "You will be redirected to eSewa to complete your payment."
                },

                khalti: {
                    title: "Khalti",
                    icon: "K",
                    color: "#5d2ba8",
                    description:
                        "You will be redirected to Khalti to complete your payment."
                },

                fonepay: {
                    title: "Fonepay",
                    icon: "F",
                    color: "#e53935",
                    description:
                        "You will be redirected to Fonepay to complete your payment."
                }

            };


            const wallet = walletData[selectedMethod];

            walletIcon.textContent = wallet.icon;
            walletIcon.style.background = wallet.color;

            walletTitle.textContent = wallet.title;
            walletDescription.textContent = wallet.description;

            if (selectedMethod === "cash") {
                payButton.textContent = `🔒 Pay NPR ${total}`;
                return;
            }

            payButton.textContent =
                `🔒 Continue with ${wallet.title}`;

        }




        /* SHOW ERROR */

        function showError(message) {

            errorMessage.textContent = message;
            errorMessage.classList.remove("hidden");

            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });

        }


        /* VALIDATE CUSTOMER */
        /* PAY */

        payButton.addEventListener("click", async () => {

            errorMessage.classList.add("hidden");
            payButton.disabled = true;
            payButton.textContent = "Processing payment...";


            try {
                fetch("payment_process.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showSuccess();
                        } else {
                            showFailure('Failed. Try again later.');
                            console.log(data.success)
                        }
                    })
                    .catch(error => console.error('Error:', error))


            } catch (error) {

                console.error(error);

                showFailure(
                    "Something went wrong while processing your payment."
                );

            }

        });


        /* SUCCESS */

        function showSuccess() {

            const orderId =
                "ORD-" +
                Date.now().toString().slice(-8);


            const methodNames = {

                cash: "Cash",

                esewa: "eSewa",

                khalti: "Khalti",

                fonepay: "Fonepay"

            };


            document.querySelector(".checkout-grid")
                .classList.add("hidden");

            document.querySelector(".checkout-header")
                .classList.add("hidden");

            successMethod.textContent =
                methodNames[selectedMethod];


            successScreen.classList.remove("hidden");

        }


        /* FAILURE */

        function showFailure(reason) {

            document.querySelector(".checkout-grid")
                .classList.add("hidden");

            document.querySelector(".checkout-header")
                .classList.add("hidden");


            failureReason.textContent = reason;

            failureScreen.classList.remove("hidden");

        }


        /* TRY AGAIN */

        tryAgain.addEventListener("click", () => {

            failureScreen.classList.add("hidden");

            document.querySelector(".checkout-grid")
                .classList.remove("hidden");

            document.querySelector(".checkout-header")
                .classList.remove("hidden");

            payButton.disabled = false;

            updatePaymentPanel();

        });
    </script>

</body>

</html>