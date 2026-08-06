<div class="popup">
    <form action="login_process.php" method="POST" class="authForm loginForm">
        <h2>Welcome Back</h2>
        <input type="hidden" name="currentUrl" class="url">
        <label for="mail">Email:</label><input type="email" id="mail" placeholder="Email" name="email" required>
        <label for="pass">Password:</label>

        <div class="password-box">
            <input type="password" id="pass" name="password" placeholder="Password" class="password" required>

            <i class="fa-solid fa-eye togglePass"></i>
        </div>
        <input type="submit" value="Login">
        <p class="switchForm">Don't have an account? <span
                style="color: #2563eb;text-decoration:underline;">Register</span></p>

        <span class="closePopUp">×</span>
    </form>


    <form action="register_process.php" method="post" class="authForm registerForm">
        <h2>Welcome </h2>
        <input type="hidden" name="currentUrl" class="url">
        <label for="r_name">Name:</label><input type="text" id="r_name" placeholder="Name" name="name" required>
        <label for="r_email">Email:</label><input type="email" id="r_email" placeholder="Email" name="email" required>
        <label for="r_pass">Password:</label>

        <div class="password-box">
            <input type="password" id="r_pass" class="password" name="password" placeholder="Password" required>
            <i class="fa-solid fa-eye togglePass"></i>
        </div>
        <label for="r_phone">Phone no:</label><input type="tel" id="r_phone" placeholder="Phone no." name="phone"
            required>
        <label for="r_sddress">Address</label><input type="text" id="r_address" placeholder="Detailed Address"
            name="address" required>
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
    let registerform = document.querySelector(".registerForm");
    let loginform = document.querySelector(".loginForm");

    document.querySelectorAll(".switchForm").forEach((el) => {
        el.addEventListener("click", (e) => {
            let text = el.querySelector("span").innerText;
            if (text == "Login") {
                registerform.style.display = "none";
                loginform.style.display = "flex";
            } else if (text == "Register") {
                registerform.style.display = "flex";
                loginform.style.display = "none";
            }
        });
    });

    const loginBtn = document.getElementById("loginBtn") || undefined;
    if (loginBtn) {
        loginBtn.addEventListener("click", () => {
            document.querySelector(".popup").style.display = "flex";
        });
    }

    document.querySelectorAll(".closePopUp").forEach((btn) => {
        btn.addEventListener("click", () => {
            document.querySelector(".popup").style.display = "none";
        });
    });

</script>