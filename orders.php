<?php require_once 'auth.php'; ?>
<?php
include 'navbar.php';
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-dark.css">
    <title>My Orders - MyShop</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #263246;
        }


        /* =====================================================
           MAIN PAGE
        ===================================================== */

        .orders-page {
            width: 100%;
            max-width: 1250px;

            margin: 40px auto;
            padding: 0 20px;

            display: grid;
            grid-template-columns: 307px 1fr;
            gap: 30px;
        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .profile-sidebar {
            background: white;
            border: 1px solid #e2e6ed;
            border-radius: 18px;

            padding: 28px 25px;

            height: fit-content;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }


        /* PROFILE */

        .sidebar-profile {
            text-align: center;
        }

        .profile-image {
            width: 108px;
            height: 108px;

            border-radius: 50%;

            object-fit: cover;

            border: 4px solid #eef5ff;

            margin-bottom: 15px;
        }

        .sidebar-profile h2 {
            font-size: 23px;
            color: #263246;
            margin-bottom: 30px;
        }


        /* DIVIDER */

        .sidebar-divider {
            height: 1px;
            background: #e2e6ed;
            margin-bottom: 18px;
        }


        /* MENU */

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;

            gap: 10px;

            text-decoration: none;

            color: #536174;

            padding: 15px 17px;

            border-radius: 10px;

            font-size: 16px;
            font-weight: 600;

            transition: 0.2s;
        }

        .sidebar-menu a:hover {
            background: #f0f5ff;
            color: #2563eb;
        }


        /* ACTIVE */

        .sidebar-menu a.active {
            background: #2864e8;
            color: white;

            box-shadow: 0 7px 16px rgba(37, 99, 235, 0.25);
        }


        /* LOGOUT */

        .sidebar-menu .logout {
            color: #e53935;
        }

        .sidebar-menu .logout:hover {
            background: #fff0f0;
            color: #e53935;
        }


        /* ICON */

        .menu-icon {
            width: 20px;
            text-align: center;
            font-size: 17px;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .orders-content {
            min-width: 0;
        }


        /* PAGE HEADING */

        .page-heading {
            margin-bottom: 25px;
        }

        .page-heading h1 {
            font-size: 28px;
            color: #17253a;
            margin-bottom: 7px;
        }

        .page-heading p {
            color: #64748b;
            font-size: 15px;
        }


        /* =====================================================
           TOP CONTROLS
        ===================================================== */

        .orders-controls {
            background: white;

            border: 1px solid #e2e6ed;

            border-radius: 14px;

            padding: 17px 20px;

            margin-bottom: 20px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;
        }


        /* FILTER */

        .filters {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-btn {
            border: 1px solid #dce2ea;

            background: white;

            color: #64748b;

            padding: 9px 16px;

            border-radius: 20px;

            cursor: pointer;

            font-size: 13px;
            font-weight: 600;

            transition: 0.2s;
        }

        .filter-btn:hover {
            border-color: #2864e8;
            color: #2864e8;
        }

        .filter-btn.active {
            background: #2864e8;
            border-color: #2864e8;
            color: white;
        }


        /* SEARCH */

        .order-search {
            position: relative;
        }

        .order-search input {
            width: 220px;

            padding: 10px 14px 10px 37px;

            border: 1px solid #dce2ea;

            border-radius: 9px;

            outline: none;

            font-size: 13px;

            color: #263246;

            background: #fafbfd;
        }

        .order-search input:focus {
            border-color: #2864e8;
        }

        .order-search input::placeholder {
            color: #9aa7b7;
        }

        .search-icon {
            position: absolute;

            left: 13px;
            top: 50%;

            transform: translateY(-50%);

            color: #8b98a8;

            font-size: 14px;
        }


        /* =====================================================
           ORDER CARD
        ===================================================== */

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .order-card {
            background: white;

            border: 1px solid #e2e6ed;

            border-radius: 14px;

            overflow: hidden;

            transition: 0.2s;

            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.025);
        }

        .order-card:hover {
            border-color: #cbd7e7;

            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        }


        /* =====================================================
           ORDER HEADER
        ===================================================== */

        .order-header {
            padding: 16px 20px;

            background: #fafbfd;

            border-bottom: 1px solid #e7ebf0;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;
        }

        .order-meta {
            display: flex;

            gap: 35px;

            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;

            flex-direction: column;

            gap: 5px;
        }

        .meta-item small {
            color: #8b98a8;

            font-size: 11px;

            text-transform: uppercase;

            font-weight: 600;
        }

        .meta-item strong {
            color: #344155;

            font-size: 13px;
        }


        /* =====================================================
           STATUS
        ===================================================== */

        .status {
            padding: 7px 13px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 700;

            white-space: nowrap;
        }

        .status.pending {
            background: #fff7d6;
            color: #b78b00;
        }

        .status.delivered {
            background: #e6f8ee;
            color: #16834b;
        }

        .status.cancel {
            background: #ffe8eb;
            color: #d9364a;
        }


        /* =====================================================
           ORDER BODY
        ===================================================== */

        .order-body {
            padding: 20px;
        }


        /* PRODUCT */

        .product {
            display: flex;

            align-items: center;

            gap: 18px;
        }


        /* IMAGE */

        .product-image {
            width: 90px;
            height: 90px;

            flex-shrink: 0;

            border-radius: 10px;

            overflow: hidden;

            background: #f2f5f8;
        }

        .product-image img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;
        }


        /* PRODUCT DETAILS */

        .product-info {
            flex: 1;
        }

        .product-info h2 {
            font-size: 17px;

            color: #263246;

            margin-bottom: 9px;
        }

        .product-info p {
            color: #7b8899;

            font-size: 13px;

            margin: 5px 0;
        }

        .product-info strong {
            color: #39475a;
        }


        /* PRICE */

        .product-total {
            min-width: 100px;

            text-align: right;

            color: #1d2c40;

            font-size: 17px;

            font-weight: 700;
        }


        /* =====================================================
           MULTIPLE PRODUCTS
        ===================================================== */

        .product+.product {
            border-top: 1px solid #edf0f4;

            padding-top: 18px;

            margin-top: 18px;
        }


        /* =====================================================
           ORDER FOOTER
        ===================================================== */

        .order-footer {
            border-top: 1px solid #e7ebf0;

            padding: 15px 20px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;
        }

        .order-total {
            color: #718096;

            font-size: 13px;
        }

        .order-total strong {
            color: #1e2d40;

            font-size: 18px;

            margin-left: 5px;
        }


        /* VIEW BUTTON */

        .view-btn {
            background: #2864e8;

            color: white;

            border: none;

            padding: 9px 17px;

            border-radius: 7px;

            font-size: 13px;

            font-weight: 600;

            cursor: pointer;

            transition: 0.2s;
        }

        .view-btn:hover {
            background: #1e55ca;
        }


        /* =====================================================
           EMPTY
        ===================================================== */

        .empty-orders {
            display: none;

            background: white;

            border: 1px solid #e2e6ed;

            border-radius: 14px;

            padding: 70px 20px;

            text-align: center;
        }

        .empty-orders .empty-icon {
            font-size: 45px;

            margin-bottom: 15px;
        }

        .empty-orders h2 {
            color: #263246;

            margin-bottom: 8px;
        }

        .empty-orders p {
            color: #8794a5;

            font-size: 14px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1050px) {

            .orders-page {
                grid-template-columns: 250px 1fr;

                gap: 20px;
            }

            .profile-sidebar {
                padding: 25px 18px;
            }

        }


        @media (max-width: 850px) {

            .orders-page {
                grid-template-columns: 1fr;

                margin-top: 25px;
            }

            .profile-sidebar {
                display: none;
            }

        }


        @media (max-width: 650px) {

            .orders-page {
                padding: 0 12px;
            }

            .page-heading h1 {
                font-size: 24px;
            }

            .orders-controls {
                flex-direction: column;

                align-items: stretch;
            }

            .filters {
                width: 100%;
            }

            .order-search input {
                width: 100%;
            }

            .order-header {
                flex-direction: column;

                align-items: flex-start;
            }

            .order-meta {
                gap: 18px;
            }

            .product {
                align-items: flex-start;
            }

            .product-image {
                width: 75px;
                height: 75px;
            }

            .product-info h2 {
                font-size: 15px;
            }

            .product-total {
                min-width: auto;

                font-size: 15px;
            }

        }


        @media (max-width: 450px) {

            .order-body {
                padding: 15px;
            }

            .product {
                display: grid;

                grid-template-columns: 65px 1fr;
            }

            .product-image {
                width: 65px;
                height: 65px;
            }

            .product-info {
                min-width: 0;
            }

            .product-total {
                grid-column: 2;

                text-align: left;
            }

            .order-footer {
                align-items: flex-start;

                flex-direction: column;
            }

            .view-btn {
                width: 100%;
            }

        }
    </style>

</head>


<body>
    <?php

    require_once "conn.php";
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $user_name = $row['name'];
        $user_profile = $row['image'] ?? 'images\users\default.png';
    }

    ?>

    <div class="orders-page">


        <!-- =================================================
             SIDEBAR
        ================================================== -->

        <aside class="profile-sidebar">


            <div class="sidebar-profile">

                <!-- Change this image to your actual profile image -->
                <img src="<?=$user_profile?>" alt="Profile" class="profile-image">

                <h2><?=$user_name?></h2>

            </div>


            <div class="sidebar-divider"></div>


            <nav class="sidebar-menu">


                <a href="profile.php">

                    <span class="menu-icon">🏠</span>

                    Dashboard

                </a>


                <a href="orders.php" class="active">

                    <span class="menu-icon">📦</span>

                    My Orders

                </a>


                <a href="wishlist.php">

                    <span class="menu-icon">❤️</span>

                    Wishlist

                </a>


                <a href="addresses.php">

                    <span class="menu-icon">📍</span>

                    Addresses

                </a>


                <a href="payment.php">

                    <span class="menu-icon">💳</span>

                    Payment Methods

                </a>


                <a href="settings.php">

                    <span class="menu-icon">⚙️</span>

                    Settings

                </a>


                <div class="sidebar-divider"></div>


                <a href="logout.php" class="logout">

                    <span class="menu-icon">🚪</span>

                    Logout

                </a>


            </nav>

        </aside>



        <!-- =================================================
             ORDERS CONTENT
        ================================================== -->

        <main class="orders-content">


            <!-- HEADING -->

            <div class="page-heading">

                <h1>My Orders</h1>

                <p>
                    View and track all your recent orders.
                </p>

            </div>



            <!-- =================================================
                 FILTER + SEARCH
            ================================================== -->

            <div class="orders-controls">


                <div class="filters">

                    <button class="filter-btn active" data-status="all">
                        All
                    </button>


                    <button class="filter-btn" data-status="pending">
                        Pending
                    </button>


                    <button class="filter-btn" data-status="delivered">
                        Delivered
                    </button>


                    <button class="filter-btn" data-status="cancel">
                        Cancelled
                    </button>

                </div>



                <div class="order-search">

                    <span class="search-icon">
                        🔍
                    </span>

                    <input type="text" id="searchOrders" placeholder="Search orders...">

                </div>


            </div>

            <div class="orders-list" id="ordersList">
                <?php
                require_once 'conn.php';
                $sql = "SELECT 
    o.*,
    p.name AS product_name,
    p.image AS product_image
FROM orders AS o
INNER JOIN products AS p
    ON o.product_id = p.id
WHERE o.user_id = '$user_id' ORDER BY o.order_date DESC;";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    ?>

                    <div class="order-card" data-status="<?= $row['status'] ?>">
                        <div class="order-header">
                            <div class="order-meta">
                                <div class="meta-item">
                                    <small>
                                        Order ID
                                    </small>
                                    <strong>
                                        #ORD-<?= $row['id'] ?>
                                    </strong>
                                </div>
                                <div class="meta-item">
                                    <small>
                                        Order Date
                                    </small>
                                    <strong>
                                        <?= date('Y-m-d', strtotime($row['order_date'])) ?>
                                    </strong>
                                </div>
                            </div>
                            <span class="status <?= $row['status'] ?>">
                                <?= $row['status'] ?>
                            </span>
                        </div>

                        <div class="order-body">
                            <div class="product">
                                <div class="product-image">
                                    <img src="<?= $row['product_image'] ?>" alt="<?= $row['product_name'] ?>">
                                </div>
                                <div class="product-info">
                                    <h2>
                                        <?= $row['product_name'] ?>
                                    </h2>
                                    <p>
                                        Quantity:
                                        <strong><?= $row['quantity'] ?></strong>
                                    </p>
                                    <p>
                                        Price:
                                        <strong>$<?php echo $row['total_price'] / $row['quantity']; ?></strong>
                                    </p>
                                </div>
                                <div class="product-total">
                                    $<?= $row['total_price'] ?>
                                </div>
                            </div>
                        </div>

                        <div class="order-footer">
                            <div class="order-total">
                                Total:
                                <strong>
                                    $<?= $row['total_price'] ?>

                                </strong>
                            </div>
                            <button class="view-btn">
                                View Order
                            </button>
                        </div>
                    </div>


                    <?php
                }
                ?>


            </div>



            <!-- =================================================
                 EMPTY RESULT
            ================================================== -->

            <div class="empty-orders" id="emptyOrders">

                <div class="empty-icon">
                    📦
                </div>

                <h2>
                    No Orders Found
                </h2>

                <p>
                    No orders match your search or selected filter.
                </p>

            </div>


        </main>


    </div>



    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script>


        const filterButtons =
            document.querySelectorAll(".filter-btn");


        const orderCards =
            document.querySelectorAll(".order-card");


        const searchInput =
            document.getElementById("searchOrders");


        const emptyOrders =
            document.getElementById("emptyOrders");


        let selectedStatus = "all";



        /* =================================================
           FILTER BUTTON
        ================================================= */

        filterButtons.forEach(button => {

            button.addEventListener("click", function () {


                filterButtons.forEach(btn => {

                    btn.classList.remove("active");

                });


                this.classList.add("active");


                selectedStatus =
                    this.dataset.status;


                filterOrders();

            });

        });



        /* =================================================
           SEARCH
        ================================================= */

        searchInput.addEventListener(
            "input",
            filterOrders
        );



        /* =================================================
           FILTER ORDERS
        ================================================= */

        function filterOrders() {


            const searchText =
                searchInput.value
                    .toLowerCase()
                    .trim();


            let visibleOrders = 0;



            orderCards.forEach(order => {


                const status =
                    order.dataset.status;


                const orderText =
                    order.innerText.toLowerCase();



                const statusMatch =
                    selectedStatus === "all" ||
                    status === selectedStatus;



                const searchMatch =
                    orderText.includes(searchText);



                if (
                    statusMatch &&
                    searchMatch
                ) {

                    order.style.display = "";

                    visibleOrders++;

                }

                else {

                    order.style.display = "none";

                }

            });



            if (visibleOrders === 0) {

                emptyOrders.style.display = "block";

            }

            else {

                emptyOrders.style.display = "none";

            }

        }

        filterOrders();

    </script>

</body>

</html>