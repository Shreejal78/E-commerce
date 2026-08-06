<?php
session_start();
require_once "conn.php";

// Later:
// Check if admin is logged in
if (!isset($_SESSION['is_admin'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* Google Font */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --bg: #0f172a;
            --bg2: #111827;
            --card: #1e293b;
            --card2: #273549;
            --primary: #3b82f6;
            --primaryHover: #2563eb;
            --green: #22c55e;
            --red: #ef4444;
            --yellow: #f59e0b;
            --text: #f8fafc;
            --text2: #94a3b8;
            --border: #334155;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0f172a, #111827, #0f172a);
            color: var(--text);
            min-height: 100vh;
        }

        /* ================= Container ================= */

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* ================= Sidebar ================= */

        .sidebar {
            width: 250px;
            position: fixed;
            height:100%;
            background: #111827;
            border-right: 1px solid var(--border);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 50px;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .sidebar nav a {
            text-decoration: none;
            color: var(--text2);
            padding: 14px 18px;
            border-radius: 12px;
            transition: .25s;
            font-weight: 500;
        }

        .sidebar nav a:hover {
            background: var(--primary);
            color: white;
        }

        .sidebar nav a.active {
            background: var(--primary);
            color: white;
        }

        .logout {
            margin-top: 25px;
            color: #ff9d9d !important;
        }

        /* ================= Main ================= */

        .main {
            flex: 1;
            padding: 35px;
            margin-left: 250px;
        }

        /* ================= Header ================= */

        header {
            display: flex;
            position: fixed;
            width: 80%;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 34px;
            font-weight: 600;
        }

        header button {
            border: none;
            background: var(--primary);
            color: white;
            padding: 14px 24px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: .25s;
        }

        header button:hover {
            background: var(--primaryHover);
            transform: translateY(-2px);
        }

        /* ================= Table ================= */

        .tableSection {
            background: var(--card);
            height: 75dvh;
            border-radius: 20px;
            margin-top: 90px;
            overflow: hidden;
            overflow-y: auto;
            border: 1px solid var(--border);
        }

        /* Scrollbar */
.tableSection::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

/* Track */
.tableSection::-webkit-scrollbar-track {
    background: #1e1e1e;
    border-radius: 10px;
}

/* Thumb */
.tableSection::-webkit-scrollbar-thumb {
    background: #6c63ff;
    border-radius: 10px;
    border: 2px solid #1e1e1e;
}

        table {
            width: 100%;
            overflow:hidden;
            overflow-y: scroll;
            border-collapse: collapse;
        }

        thead {
            background: #172233;
        }

        thead th {
            padding: 18px;
            text-align: left;
            color: #fff;
            font-weight: 600;
        }

        tbody td {
            padding: 18px;
            border-top: 1px solid var(--border);
            color: #d8dee9;
        }

        tbody tr {
            transition: .2s;
        }

        tbody tr:hover {
            background: #243447;
        }

        tbody img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* ================= Buttons ================= */

        .editBtn,
        .deleteBtn {
            border: none;
            padding: 9px 15px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            margin-right: 6px;
            transition: .2s;
        }

        .editBtn {
            background: var(--yellow);
        }

        .editBtn:hover {
            transform: translateY(-2px);
        }

        .deleteBtn {
            background: var(--red);
        }

        .deleteBtn:hover {
            transform: translateY(-2px);
        }

        /* ================= Popup ================= */

        .popup {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .65);
            display: flex;
            justify-content: center;
            align-items: center;
            visibility: hidden;
            opacity: 0;
            z-index: 50;
            transition: .25s;
        }

        .popup.active {
            visibility: visible;
            opacity: 1;
        }

        .popupContent {
            width: 95%;
            max-width: 560px;
            height: 100%;
            overflow: hidden;
            overflow-y: scroll;
            min-height: 550px;
            background: var(--card);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid var(--border);
            animation: popup .25s;
        }

        .popupContent::-webkit-scrollbar {
            display: none;
        }

        .stock {
            display: inline-block;
            min-width: 45px;
            text-align: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
        }

        .inStock {
            background: #1b5e20;
            color: #8fff9d;
        }

        .lowStock {
            background: #5c4200;
            color: #ffd54f;
        }

        .outStock {
            background: #5c1616;
            color: #ff8a8a;
        }

        .actions {
            white-space: nowrap;
        }

        @keyframes popup {

            from {
                transform: scale(.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }

        }

        .popupHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .popupHeader h2 {
            font-size: 28px;
        }

        .popupHeader span {
            font-size: 35px;
            cursor: pointer;
            color: var(--text2);
        }

        .popupHeader span:hover {
            color: white;
        }

        /* ================= Form ================= */

        .inputGroup {
            display: flex;
            flex-direction: column;
            margin-bottom: 18px;
        }

        .inputGroup label {
            margin-bottom: 8px;
            color: var(--text2);
        }

        .inputGroup input,
        .inputGroup select,
        .inputGroup textarea {
            background: #111827;
            border: 1px solid var(--border);
            color: white;
            padding: 13px;
            border-radius: 10px;
            outline: none;
            transition: .2s;
        }

        .inputGroup input:focus,
        .inputGroup select:focus,
        .inputGroup textarea:focus {
            border-color: var(--primary);
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .submitBtn {
            width: 100%;
            margin-top: 10px;
            border: none;
            background: var(--green);
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: .25s;
        }

        .submitBtn:hover {
            background: #16a34a;
        }

        /* ================= Responsive ================= */

        @media(max-width:900px) {

            .sidebar {
                width: 80px;
                padding: 20px 10px;
            }

            .logo {
                font-size: 18px;
                text-align: center;
            }

            .sidebar nav a {
                text-align: center;
                font-size: 0;
            }

            .sidebar nav a::first-letter {
                font-size: 20px;
            }

        }

        @media(max-width:700px) {

            .main {
                padding: 20px;
            }

            header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .row {
                grid-template-columns: 1fr;
            }

            table {
                min-width: 700px;
            }

            .tableSection {
                overflow: auto;
            }

        }

        .fileUpload {
            width: 100%;
            height: 100px;
            border: 2px dashed #3b82f6;
            border-radius: 16px;
            background: #111827;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: .25s;
            position: relative;
            overflow: hidden;
        }

        .fileUpload:hover {
            background: #162135;
            border-color: #60a5fa;
        }

        .fileUpload input {
            display: none;
        }



        .uploadText {
            color: #cbd5e1;
            font-size: 15px;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Sidebar -->
        <aside class="sidebar">

            <div class="logo">
                Admin Panel
            </div>

            <nav>

                <a href="#" class="active">
                    📦 Products
                </a>

                <a href="#">
                    📂 Categories
                </a>

                <a href="#">
                    🛒 Orders
                </a>

                <a href="#">
                    👤 Users
                </a>

                <a href="#">
                    ⚙ Settings
                </a>

                <a href="logout.php" class="logout">
                    🚪 Logout
                </a>

            </nav>

        </aside>



        <!-- Main -->
        <main class="main">

            <header>

                <h1>Product Management</h1>

                <button id="openPopup">
                    + Add Product
                </button>

            </header>



            <!-- Products Table -->

            <section class="tableSection">

                <table>

                    <thead>

                        <tr>

                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody id="productTable">
                        <?php
                        require_once 'conn.php';
                        $sql = 'SELECT * FROM products';
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr class="productItem">
                                <td>
                                    <img src="<?= $row['image']; ?>" alt="Product">
                                </td>
                                <td>
                                    <?= $row['name']; ?>
                                </td>
                                <td>
                                    <?= $row['category']; ?>
                                </td>
                                <td>
                                    $<?= $row['price']; ?>
                                </td>
                                <td>
                                    <span class="stock inStock">
                                        <?= $row['quantity']; ?>
                                    </span>
                                </td>
                                <td class="actions">
                                    <button class="editBtn" data-id="<?= $row['id']; ?>" data-name="<?= $row['name']; ?>"
                                        data-category="<?= $row['category']; ?>"
                                        data-price="<?= $row['price']; ?>" data-quantity="<?= $row['quantity']; ?>" data-image="<?= $row['image']; ?>">
                                        ✏ Edit
                                    </button>
                                    <button class="deleteBtn" data-id="<?= $row['id']; ?>">
                                        🗑 Delete
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>

                </table>

            </section>

        </main>

    </div>


    <div class="popup" id="popup">
        <div class="popupContent">
            <div class="popupHeader">
                <h2>Add Product</h2>
                <span id="closePopup">&times;</span>
            </div>
            <form action="productUpload.php" method="POST" enctype="multipart/form-data">

                <div class="inputGroup">

                    <label>Product Image</label>

                    <label class="fileUpload">

                        <input type="file" name="image" id="imageInput" accept="image/*" required>
                        <span class="uploadText">
                            Choose Product Image
                        </span>

                    </label>

                </div>

                <div class="inputGroup">

                    <label>Product Name</label>

                    <input type="text" name="name" required>

                </div>

                <div class="inputGroup">

                    <label>Category</label>

                    <input type="text" name="category" required>

                </div>

                <div class="row">

                    <div class="inputGroup">

                        <label>Price</label>

                        <input type="number" name="price" step="0.01" required>

                    </div>

                    <div class="inputGroup">

                        <label>Quantity</label>

                        <input type="number" name="quantity" required>

                    </div>

                </div>

                <button type="submit" class="submitBtn">
                    Upload Product
                </button>

            </form>

        </div>
    </div>
    <div class="popup" id="editPopup">
        <div class="popupContent">
            <div class="popupHeader">
                <h2>Edit Product</h2>
                <span id="closeEditPopup">&times;</span>
            </div>
            <form action="editProduct.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" id="editProductId">
                <div class="inputGroup">
                    <label id="editImgView">Current Image</label>
                    <img id="currentImage" src="" alt="Product Image"
                        style="width:140px;height:140px;object-fit:cover;border-radius:12px;margin-bottom:15px;">

                </div>
                <div class="inputGroup">
                    <label>Choose New Image (Optional)</label>
                    <label class="fileUpload">
                        <input type="file" name="image" id="editImageInput" accept="image/*">
                        <span class="uploadIcon">📷</span>
                        <span class="uploadText">Choose New Image</span>
                    </label>
                </div>
                <div class="inputGroup">
                    <label>Product Name</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                <div class="inputGroup">
                    <label>Category</label>
                    <input type="text" name="category" id="editCategory" required>
                </div>
                <div class="row">
                    <div class="inputGroup">
                        <label>Price</label>
                        <input type="number" name="price" id="editPrice" step="0.01" required>
                    </div>
                    <div class="inputGroup">
                        <label>Quantity</label>
                        <input type="number" name="quantity" id="editQuantity" required>
                    </div>
                </div>
                <button class="submitBtn">
                    Save Changes
                </button>
            </form>
        </div>
    </div>

    <script>
        const popup = document.getElementById("popup");
        const openPopup = document.getElementById("openPopup");
        const closePopup = document.getElementById("closePopup");
        const editInp = document.getElementById('editImageInput');
        const imageInput = document.getElementById('imageInput');
        let currentImage = document.getElementById('currentImage');


        editInp.addEventListener('change', () => {
            const file = editInp.files[0];
            let view = document.getElementById('editImgView')
            currentImage.src = URL.createObjectURL(file);
            view.innerText = 'New Image'
            currentImage.style.border = '2px solid lime'
        })
        // ---------- Open Popup ----------

        openPopup.addEventListener("click", () => {
            popup.classList.add("active");
        });

        // ---------- Close Popup ----------

        closePopup.addEventListener("click", () => {
            popup.classList.remove("active");
        });

        // ---------- Click Outside ----------

        popup.addEventListener("click", (e) => {
            if (e.target === popup) {
                popup.classList.remove("active");
            }
        });

        // ---------- ESC Key ----------

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                popup.classList.remove("active");
            }
        });

        // ---------- Image Preview ----------

        // Create preview element
        const preview = document.createElement("img");

        preview.style.width = "80px";
        preview.style.height = "80px";
        preview.style.objectFit = "cover";
        preview.style.borderRadius = "12px";
        preview.style.display = "none";
        preview.style.border = "2px solid #334155";

        // Insert below file input
        imageInput.parentElement.appendChild(preview);

        imageInput.addEventListener("change", () => {

            const file = imageInput.files[0];
            let text = document.querySelector('.uploadText');
            if (!file) {
                preview.style.display = "none";
                preview.src = "";
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
            text.innerText = 'Chosen Product Image: '
            console.log(imageInput.parentElement)
        });

        // ---------- Delete Confirmation ----------

        let deleteBtn = document.querySelectorAll('.deleteBtn')
        deleteBtn.forEach(btn => {
            btn.addEventListener('click', async (e)=> {
                
                const confirmDelete = confirm(
                    "Are you sure you want to delete this product?"
                );
                if (!confirmDelete) {
                    e.preventDefault();
                    return;
                }

                fetch("deleteProduct.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `product_id=${btn.dataset.id}`
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            btn.closest('.productItem').remove();
                            alert('Product removed Successfully!');
                        } else {
                            console.error(data);
                        }
                    })
                    .catch(error => console.error('Error:', error))
            })
        });

        const editPopup = document.getElementById("editPopup");
        const closeEditPopup = document.getElementById("closeEditPopup");

        document.querySelectorAll(".editBtn").forEach(btn => {

            btn.addEventListener("click", () => {
                console.log('sdfgsdf')
                document.getElementById("editProductId").value = btn.dataset.id;
                document.getElementById("editName").value = btn.dataset.name;
                document.getElementById("editCategory").value = btn.dataset.category;
                document.getElementById("editPrice").value = btn.dataset.price;
                document.getElementById("editQuantity").value = btn.dataset.quantity;
                document.getElementById("currentImage").src = btn.dataset.image;

                editPopup.classList.add("active");

            });

        });

        closeEditPopup.onclick = () => {
            editPopup.classList.remove("active");
        };

        editPopup.addEventListener("click", (e) => {

            if (e.target === editPopup) {
                editPopup.classList.remove("active");
            }

        });

    document.addEventListener("paste", (e) => {

    // Find an image in the clipboard
    const imageItem = [...e.clipboardData.items].find(item =>
        item.type.startsWith("image/")
    );

    if (!imageItem) return;

    // Find the file input inside the currently visible popup
    const fileInput = document.querySelector(".popup.active input[type='file']");

    if (!fileInput) return;

    // Create a FileList
    const file = imageItem.getAsFile();
    const dt = new DataTransfer();
    dt.items.add(file);

    // Assign to the file input
    fileInput.files = dt.files;

    // Trigger the change event (for image preview)
    fileInput.dispatchEvent(new Event("change", { bubbles: true }));

});
    </script>

</body>

</html>