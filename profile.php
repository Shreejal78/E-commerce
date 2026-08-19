<?php
require_once 'auth.php';

require_once("navBar.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Account</title>
    <link rel="stylesheet" href="style-dark.css">
    <style>
        .account-page {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
            --background: #f5f7fb;
            --white: #ffffff;

            width: 100%;
            min-height: 100vh;
            background: var(--background);
            padding: 35px 20px 60px;

            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }


        .account-page .account-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;

            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);

            gap: 25px;
            align-items: start;
        }

        .account-page .account-sidebar {
            width: 100%;
            background: var(--white);

            border: 1px solid var(--border);
            border-radius: 16px;

            padding: 22px;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, 0.05);

            position: sticky;
            top: 20px;
        }

        .account-page .account-profile {
            text-align: center;

            padding-bottom: 22px;

            border-bottom: 1px solid var(--border);
        }

      
        .account-page .profile-image {
            width: 100%;
            height: 100%;
            display: block;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #eff6ff;
            background: #f3f4f6;
        }
        .profile{
            display: flex;
            justify-self: center;
            height: 95px ;
            position: relative;
            width: 95px ;
            border-radius: 50%;
            overflow: hidden;
        }
        .profile:hover::before {
            content: '📷';
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            height: 95px ;
            width: 95px ;
            background: rgba(0, 0, 0, 0.4);
            cursor: pointer;
            font-size: 30px;
        }

        .account-page .account-profile h2 {
            font-size: 19px;
            line-height: 1.3;

            margin: 0 0 5px;

            color: var(--text);
        }


        .account-page .account-profile p {
            margin: 0;

            color: var(--muted);

            font-size: 13px;

            word-break: break-word;
        }

        .account-page .account-menu {
            list-style: none;

            margin: 20px 0 0;
            padding: 0;
        }


        .account-page .account-menu li {
            list-style: none;

            margin: 4px 0;
            padding: 0;
        }


        .account-page .account-menu a {
            display: flex;
            align-items: center;

            gap: 11px;

            width: 100%;

            padding: 12px 13px;

            border-radius: 9px;

            text-decoration: none;

            color: #4b5563;

            font-size: 14px;
            font-weight: 500;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;
        }


        .account-page .account-menu a:hover {
            background: #eff6ff;
            color: var(--primary);

            transform: translateX(3px);
        }


        .account-page .account-menu a.active {
            background: var(--primary);
            color: white;

            box-shadow:
                0 5px 12px rgba(37, 99, 235, .20);
        }


        .account-page .account-menu a.logout {
            color: #dc2626;

            margin-top: 12px;

            border-top: 1px solid var(--border);

            border-radius: 0 0 9px 9px;

            padding-top: 16px;
        }


        .account-page .account-menu a.logout:hover {
            background: #fef2f2;
            color: #dc2626;

            transform: none;
        }


        .account-page .account-content {
            min-width: 0;
            width: 100%;
        }


        .account-page .account-heading {
            margin-bottom: 22px;
        }


        .account-page .account-heading h1 {
            margin: 0 0 6px;

            font-size: 28px;
            line-height: 1.3;

            color: var(--text);
        }


        .account-page .account-heading p {
            margin: 0;

            color: var(--muted);

            font-size: 14px;
            line-height: 1.6;
        }

        .account-page .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 16px;

            margin-bottom: 20px;
        }


        .account-page .stat-card {
            min-width: 0;

            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 14px;

            padding: 20px;

            display: flex;
            align-items: center;

            gap: 14px;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .04);

            transition: .2s ease;
        }


        .account-page .stat-card:hover {
            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(0, 0, 0, .07);
        }


        .account-page .stat-icon {
            width: 48px;
            height: 48px;

            flex: 0 0 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            font-size: 20px;
        }


        .account-page .stat-icon.blue {
            background: #eff6ff;
        }


        .account-page .stat-icon.pink {
            background: #fdf2f8;
        }


        .account-page .stat-icon.green {
            background: #ecfdf5;
        }


        .account-page .stat-info {
            min-width: 0;
        }


        .account-page .stat-info strong {
            display: block;

            font-size: 22px;

            color: var(--text);

            margin-bottom: 3px;
        }


        .account-page .stat-info span {
            display: block;

            color: var(--muted);

            font-size: 12px;
        }

        .account-page .account-card {
            width: 100%;

            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 14px;

            padding: 24px;

            margin-bottom: 20px;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .04);
        }


        .account-page .card-title {
            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding-bottom: 17px;

            margin-bottom: 20px;

            border-bottom: 1px solid var(--border);
        }


        .account-page .card-title h2 {
            margin: 0;

            font-size: 18px;

            color: var(--text);
        }


        .account-page .card-title a {
            color: var(--primary);

            text-decoration: none;

            font-size: 13px;
            font-weight: 600;

            white-space: nowrap;
        }


        .account-page .card-title a:hover {
            text-decoration: underline;
        }

        .account-page .form-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 18px;
        }


        .account-page .form-group {
            min-width: 0;
        }


        .account-page .form-group label {
            display: block;

            margin-bottom: 7px;

            color: #4b5563;

            font-size: 13px;
            font-weight: 600;
        }


        .account-page .form-group input,
        .account-page .form-group textarea {
            width: 100%;

            display: block;

            padding: 12px 13px;

            border: 1px solid #d9dde5;

            border-radius: 8px;

            background: #fff;

            color: var(--text);

            font-size: 14px;

            outline: none;

            transition: .2s ease;

            font-family: inherit;
        }


        .account-page .form-group input {
            height: 44px;
        }


        .account-page .form-group textarea {
            min-height: 110px;

            resize: vertical;
        }


        .account-page .form-group input:focus,
        .account-page .form-group textarea:focus {
            border-color: var(--primary);

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .10);
        }


        .account-page .form-group input[readonly] {
            background: #f8fafc;
            color: #9ca3af;
            cursor: not-allowed;
        }


        .account-page .primary-btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-height: 43px;

            margin-top: 18px;

            padding: 0 20px;

            border: 0;
            border-radius: 8px;

            background: var(--primary);

            color: white;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;

            transition: .2s ease;
        }


        .account-page .primary-btn:hover {
            background: var(--primary-dark);

            transform: translateY(-1px);

            box-shadow:
                0 5px 12px rgba(37, 99, 235, .20);
        }


        .account-page .address-box {
            border: 1px solid var(--border);

            background: #fafbfc;

            border-radius: 10px;

            padding: 18px;
        }


        .account-page .address-header {
            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 10px;

            margin-bottom: 10px;
        }


        .account-page .address-header h3 {
            margin: 0;

            font-size: 15px;
        }


        .account-page .default-label {
            background: #dcfce7;

            color: #15803d;

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
        }


        .account-page .address-box p {
            margin: 0;

            color: #6b7280;

            font-size: 14px;

            line-height: 1.7;
        }

        .account-page .table-container {
            width: 100%;

            overflow-x: auto;

            -webkit-overflow-scrolling: touch;
        }


        .account-page .orders-table {
            width: 100%;

            min-width: 620px;

            border-collapse: collapse;
        }


        .account-page .orders-table th {
            background: #f8fafc;

            color: #6b7280;

            font-size: 12px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .3px;
        }


        .account-page .orders-table th,
        .account-page .orders-table td {
            padding: 14px 12px;

            border-bottom: 1px solid var(--border);

            text-align: left;
        }


        .account-page .orders-table td {
            color: #4b5563;

            font-size: 13px;
        }


        .account-page .orders-table tbody tr:last-child td {
            border-bottom: none;
        }


        .account-page .orders-table tbody tr:hover {
            background: #fafcff;
        }


        .account-page .order-id {
            color: var(--primary) !important;

            font-weight: 700;
        }


        .account-page .status {
            display: inline-flex;

            align-items: center;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 11px;
            font-weight: 700;

            white-space: nowrap;
        }


        .account-page .status.delivered {
            background: #dcfce7;
            color: #15803d;
        }


        .account-page .status.pending {
            background: #fef3c7;
            color: #a16207;
        }


        .account-page .status.cancel {
            background: #fee2e2;
            color: #b91c1c;
        }


        .account-page .view-order {
            color: var(--primary);

            text-decoration: none;

            font-weight: 600;

            font-size: 13px;
        }


        .account-page .view-order:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {

            .account-page {
                padding: 25px 15px 45px;
            }


            .account-page .account-wrapper {
                grid-template-columns: 220px minmax(0, 1fr);

                gap: 18px;
            }


            .account-page .stats-grid {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 700px) {

            .account-page {
                padding: 20px 12px 40px;
            }


            .account-page .account-wrapper {
                display: flex;

                flex-direction: column;

                gap: 18px;
            }


            .account-page .account-sidebar {
                position: static;

                padding: 18px;
            }


            .account-page .account-profile {
                display: flex;

                align-items: center;

                text-align: left;

                gap: 14px;

                padding-bottom: 18px;
            }


            .account-page .profile-image {
                width: 70px;
                height: 70px;

                flex: 0 0 70px;

                margin: 0;
            }


            .account-page .account-menu {
                display: grid;

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                gap: 5px;

                margin-top: 15px;
            }


            .account-page .account-menu li {
                margin: 0;
            }


            .account-page .account-menu a {
                justify-content: center;

                text-align: center;

                padding: 11px 7px;

                font-size: 12px;
            }


            .account-page .account-menu a:hover {
                transform: none;
            }


            .account-page .account-menu a.logout {
                margin-top: 0;

                border-top: 0;

                padding-top: 11px;
            }


            .account-page .account-heading h1 {
                font-size: 24px;
            }


            .account-page .account-card {
                padding: 18px;

                margin-bottom: 16px;
            }


            .account-page .form-grid {
                grid-template-columns: 1fr;

                gap: 15px;
            }


            .account-page .card-title h2 {
                font-size: 17px;
            }

        }


        @media (max-width: 420px) {

            .account-page .account-menu {
                grid-template-columns: 1fr;
            }


            .account-page .stats-grid {
                gap: 10px;
            }


            .account-page .stat-card {
                padding: 16px;
            }


            .account-page .card-title {
                align-items: flex-start;

                flex-direction: column;

                gap: 7px;
            }


            .account-page .card-title a {
                font-size: 12px;
            }


            .account-page .primary-btn {
                width: 100%;
            }

        }
    </style>

</head>


<body>

    <?php

    require_once "conn.php";
    require_once 'loginPopUp.php';

    $user_id = $_SESSION['user_id'];
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

    <div class="account-page">

        <div class="account-wrapper">



            <aside class="account-sidebar">

                <div class="account-profile">
                    <label for="profile_image" class="profile" title="Change Profile">
                        <img src="<?= $user_profile ?>" alt="Profile" class="profile-image">
                    </label>

                    <input type="file" name="image" id="profile_image" accept="image/*" style="visibility:hidden;">

                    <div>

                        <h2>
                            <?php echo htmlspecialchars($user_name); ?>
                        </h2>

                    </div>

                </div>


                <ul class="account-menu">

                    <li>
                        <a href="profile.php" class="active">
                            🏠 Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="orders.php">
                            📦 My Orders
                        </a>
                    </li>

                    <li>
                        <a href="wishlist.php">
                            ❤️ Wishlist
                        </a>
                    </li>

                    <li>
                        <a href="addresses.php">
                            📍 Addresses
                        </a>
                    </li>

                    <li>
                        <a href="payment_methods.php">
                            💳 Payment Methods
                        </a>
                    </li>

                    <li>
                        <a href="settings.php">
                            ⚙️ Settings
                        </a>
                    </li>

                    <li>
                        <a href="logout.php" class="logout">
                            🚪 Logout
                        </a>
                    </li>

                </ul>

            </aside>

            <main class="account-content">
                <div class="account-heading">

                    <h1>
                        <p> <?php echo "$user_name"; ?></p>
                    </h1>

                    <p>
                        Manage your personal information, orders and shopping preferences.
                    </p>

                </div>

                <div class="stats-grid">

                    <div class="stat-card">

                        <div class="stat-icon blue">
                            📦
                        </div>

                        <div class="stat-info">

                            <strong><?php if (isset($_SESSION["user_id"])) {


                                $user_id = $_SESSION['user_id'];
                                $sql = "SELECT SUM(quantity) AS order_count FROM orders WHERE user_id = $user_id";

                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);

                                $order_count = $row['order_count'] ?? 0;
                                echo $order_count;
                            }
                            ?></strong>

                            <span>
                                Total Orders
                            </span>

                        </div>

                    </div>


                    <div class="stat-card">

                        <div class="stat-icon pink">
                            ❤️
                        </div>

                        <div class="stat-info">

                            <strong>5</strong>

                            <span>
                                Wishlist Items
                            </span>

                        </div>

                    </div>


                    <div class="stat-card">

                        <div class="stat-icon green">
                            🛒
                        </div>

                        <div class="stat-info">

                            <strong><?php if (isset($_SESSION["user_id"])) {


                                $user_id = $_SESSION['user_id'];
                                $sql = "SELECT SUM(quantity) AS cart_count FROM cart WHERE user_id = $user_id";

                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);

                                $cart_count = $row['cart_count'] ?? 0;
                                echo $cart_count;
                            }
                            ?></strong>

                            <span>
                                Cart Items
                            </span>

                        </div>

                    </div>

                </div>



                <div class="account-card">

                    <div class="card-title">

                        <h2>
                            Personal Information
                        </h2>

                        <a href="settings.php">
                            Edit Profile
                        </a>

                    </div>


                    <form action="update_profile.php" method="POST">

                        <div class="form-grid">


                            <div class="form-group">

                                <label>
                                    Full Name
                                </label>

                                <input type="text" name="name" value="<?php echo htmlspecialchars($user_name); ?>">

                            </div>


                            <div class="form-group">

                                <label>
                                    Email Address
                                </label>

                                <input type="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>">

                            </div>


                            <div class="form-group">

                                <label>
                                    Phone Number
                                </label>

                                <input type="text" name="phone" value="<?php echo htmlspecialchars($user_phone); ?>">

                            </div>
                            <div class="form-group">

                                <label>
                                    Password
                                </label>

                                <input type="text" name="password"
                                    value="<?php echo htmlspecialchars($user_password); ?>">

                            </div>
                            <div class="form-group">

                                <label>
                                    Address
                                </label>

                                <input type="text" name="address"
                                    value="<?php echo htmlspecialchars($user_address); ?>">

                            </div>

                            <div class="form-group">

                                <label>
                                    Customer ID
                                </label>

                                <input type="text" value="#<?php echo $user_id; ?>" readonly>

                            </div>


                        </div>


                        <button type="submit" class="primary-btn">
                            Save Changes
                        </button>

                    </form>

                </div>

                <div class="account-card">

                    <div class="card-title">

                        <h2>
                            Shipping Address
                        </h2>

                        <a href="addresses.php">
                            Manage Addresses
                        </a>

                    </div>


                    <div class="address-box">

                        <div class="address-header">

                            <h3>
                                Default Address
                            </h3>

                            <span class="default-label">
                                DEFAULT
                            </span>

                        </div>


                        <p>
                            <?php echo htmlspecialchars($user_name); ?><br>
                            <?php echo ($user_address) ?><br>

                        </p>

                    </div>

                </div>
                <div class="account-card">

                    <div class="card-title">

                        <h2>
                            Recent Orders
                        </h2>

                        <a href="orders.php">
                            View All
                        </a>

                    </div>
                    <div class="table-container">

                        <table class="orders-table">

                            <thead>

                                <tr>

                                    <th>
                                        Order
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Total
                                    </th>

                                    <th>
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <tr>

                                    <td class="order-id"> #1001</td>

                                    <td>Aug 05, 2026</td>

                                    <td>
                                        <span class="status cancel">Delivered</span>
                                    </td>

                                    <td>Rs. 12,000</td>

                                    <td>
                                        <a href="order_details.php?id=1001" class="view-order"> View</a>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

<script>
    let profileInp = document.getElementById('profile_image');

    profileInp.addEventListener('change', async () => {
        const formData = new FormData();
        formData.append('image', profileInp.files[0]);
        let res = await fetch("changeProfile.php", {
            method: "POST",
            body: formData
        });
        let data = await res.json();
        if (data.success) {
            document.querySelector('.profile-image').src = data.newPath;
        }
    });
</script>

</html>