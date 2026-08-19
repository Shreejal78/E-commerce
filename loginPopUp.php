<div class="popup">
    <form action="login_process.php" method="POST" class="authForm loginForm">
        <h2>Welcome Back</h2>
        <input type="hidden" name="currentUrl" class="url">
        <label for="mail">Email:</label><input type="email" id="mail" placeholder="Email" name="email">
        <label for="pass">Password:</label>

        <div class="password-box">
            <input type="password" id="pass" name="password" placeholder="Password" class="password">

            <i class="fa-solid fa-eye togglePass"></i>
        </div>
        <input type="submit" value="Login">
        <p class="switchForm">Don't have an account? <span
                style="color: #2563eb;text-decoration:underline;">Register</span></p>

        <span class="closePopUp">×</span>
    </form>


    <form action="register_process.php" method="post" class="authForm registerForm">
        <h2>Register</h2>
        <input type="hidden" name="currentUrl" class="url">
        <label for="r_name">Name:</label><input type="text" id="r_name" placeholder="Name" name="name">
        <label for="r_email">Email:</label><input type="email" id="r_email" placeholder="Email" name="email">
        <label for="r_pass">Password:</label>

        <div class="password-box">
            <input type="password" id="r_pass" class="password" name="password" placeholder="Password">
            <i class="fa-solid fa-eye togglePass"></i>
        </div>
        <label for="r_phone">Phone no:</label><input type="tel" id="r_phone" placeholder="Phone no." name="phone">
        <label for="r_sddress">Address</label><input type="text" id="r_address" placeholder="Detailed Address"
            name="address">
        <input type="submit" value="Register">
        <p class="switchForm">Already have an account? <span
                style="color: #2563eb;text-decoration:underline;">Login</span></p>
        <span class="closePopUp">×</span>

    </form>
</div>

<script>
    const toggle = document.querySelectorAll(".togglePass");
    toggle.forEach((el) => {
        el.addEventListener("click", (e) => {
            let password = e.target.parentElement.querySelector(".password");
            if (password.type === "password") {
                password.type = "text";
                el.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                password.type = "password";
                el.classList.replace("fa-eye-slash", "fa-eye");
            }
        });
    });

    const loginForm = document.querySelector(".loginForm");
    const registerForm = document.querySelector(".registerForm");

    // =========================
    // Helper functions
    // =========================

    function showError(input, message) {
        removeError(input);

        input.classList.add("input-error");

        const error = document.createElement("small");
        error.className = "form-error";
        error.textContent = message;

        input.insertAdjacentElement("afterend", error);
    }

    function removeError(input) {
        input.classList.remove("input-error");

        const next = input.nextElementSibling;

        if (next && next.classList.contains("form-error")) {
            next.remove();
        }
    }

    function validEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validPhone(phone) {
        // Nepal phone number: 10 digits starting with 9
        return /^9\d{9}$/.test(phone);
    }


    // =========================
    // LOGIN VALIDATION
    // =========================

    loginForm.addEventListener("submit", (e) => {

        let valid = true;

        const email = document.getElementById("mail");
        const password = document.getElementById("pass");

        // Email
        if (email.value.trim() === "") {
            showError(email, "Email is required");
            valid = false;
        }
        else if (!validEmail(email.value.trim())) {
            showError(email, "Enter a valid email address");
            valid = false;
        }
        else {
            removeError(email);
        }


        // Password
        if (password.value.trim() === "") {
            showError(password, "Password is required");
            valid = false;
        }
        else if (password.value.length < 6) {
            showError(password, "Password must be at least 6 characters");
            valid = false;
        }
        else {
            removeError(password);
        }


        if (!valid) {
            e.preventDefault();
        }
    });


    // =========================
    // REGISTER VALIDATION
    // =========================

    registerForm.addEventListener("submit", (e) => {

        let valid = true;

        const name = document.getElementById("r_name");
        const email = document.getElementById("r_email");
        const password = document.getElementById("r_pass");
        const phone = document.getElementById("r_phone");
        const address = document.getElementById("r_address");


        // Name
        if (name.value.trim() === "") {
            showError(name, "Name is required");
            valid = false;
        }
        else if (name.value.trim().length < 3) {
            showError(name, "Name must be at least 3 characters");
            valid = false;
        }
        else if (!/^[a-zA-Z\s]+$/.test(name.value.trim())) {
            showError(name, "Name can only contain letters");
            valid = false;
        }
        else {
            removeError(name);
        }


        // Email
        if (email.value.trim() === "") {
            showError(email, "Email is required");
            valid = false;
        }
        else if (!validEmail(email.value.trim())) {
            showError(email, "Enter a valid email address");
            valid = false;
        }
        else {
            removeError(email);
        }


        // Password
        if (password.value === "") {
            showError(password, "Password is required");
            valid = false;
        }
        else if (password.value.length < 8) {
            showError(password, "Password must be at least 8 characters");
            valid = false;
        }
        else if (!/[A-Z]/.test(password.value)) {
            showError(password, "Password must contain an uppercase letter");
            valid = false;
        }
        else if (!/[a-z]/.test(password.value)) {
            showError(password, "Password must contain a lowercase letter");
            valid = false;
        }
        else if (!/[0-9]/.test(password.value)) {
            showError(password, "Password must contain a number");
            valid = false;
        }
        else {
            removeError(password);
        }


        // Phone
        if (phone.value.trim() === "") {
            showError(phone, "Phone number is required");
            valid = false;
        }
        else if (!validPhone(phone.value.trim())) {
            showError(phone, "Enter a valid 10-digit phone number");
            valid = false;
        }
        else {
            removeError(phone);
        }


        // Address
        if (address.value.trim() === "") {
            showError(address, "Address is required");
            valid = false;
        }
        else if (address.value.trim().length < 5) {
            showError(address, "Please enter a valid address");
            valid = false;
        }
        else {
            removeError(address);
        }


        if (!valid) {
            e.preventDefault();
        }
    });


    // =========================
    // Remove error while typing
    // =========================

    document.querySelectorAll(".authForm input").forEach(input => {

        input.addEventListener("input", () => {
            removeError(input);
        });

    });


    let urls = document.querySelector('.url')
    loginForm.addEventListener('submit', (e) => {
        const params = new URLSearchParams(window.location.search);

    })


    document.querySelectorAll(".switchForm").forEach((el) => {
        el.addEventListener("click", (e) => {
            let text = el.querySelector("span").innerText;
            if (text == "Login") {
                registerForm.style.display = "none";
                loginForm.style.display = "flex";
            } else if (text == "Register") {
                registerForm.style.display = "flex";
                loginForm.style.display = "none";
            }
        });
    });

    const loginBtn = document.getElementById("loginBtn") || undefined;
    if (loginBtn) {
        loginBtn.addEventListener("click", () => {
            document.querySelector(".popup").style.display = "flex";
            document.body.classList.add("popup-open");
        });
    }

    document.querySelectorAll(".closePopUp").forEach((btn) => {
        btn.addEventListener("click", () => {
            document.querySelector(".popup").style.display = "none";
            document.body.classList.remove("popup-open");

        });
    });

</script>