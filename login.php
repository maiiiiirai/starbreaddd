<?php
    require_once('./backend/utils/db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetBrid Inventory System - Login</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Your Christmas Login CSS -->
    <link rel="stylesheet" href="./frontend/assets/css/login.css">
</head>


<body class="min-h-full">

    <div class="content-wrapper min-h-full flex items-center justify-center">

        <?php include('./frontend/pages/component/toast.php');?>

        <div class="max-w-md w-full">
            <div class="login-card">

                <div class="text-center mb-6">
                    <h2 class="login-title"> Welcome to Santa's Bread!</h2>
                    <p class="login-subtitle">Please log in to access the inventory system</p>
                </div>

                <form id="loginForm" method="POST" action="../../backend/auth/login.php">

                    <div class="mb-4">
                        <label class="login-label" for="username">Username</label>
                        <input class="login-input" type="text" id="username" name="username" required>
                    </div>

                    <div class="mb-6">
                        <label class="login-label" for="password">Password</label>
                        <input class="login-input" type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="login-btn">
                        🎅 Log In
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="#" class="forgot-link">Forgot your password?</a>
                </div>

            </div>
        </div>
    </div>

    <script type="module" src="./frontend/assets/js/auth/login.js"></script>


<script>
document.addEventListener("DOMContentLoaded", () => {
    
    // Generate 2–6 floating cookies
    const cookieCount = Math.floor(Math.random() * 5) + 2;

    for (let i = 0; i < cookieCount; i++) {
        let cookie = document.createElement("div");
        cookie.classList.add("cookie-float");

        // You can replace with your own cookie emoji or PNG  
        cookie.innerHTML = "🍪";  

        // Random size (40px–90px)
        const size = Math.random() * 50 + 40;
        cookie.style.fontSize = size + "px";

        // Random horizontal starting position
        cookie.style.left = Math.random() * 90 + "vw";

        // Random vertical position (10%–80%)
        cookie.style.top = Math.random() * 70 + 10 + "vh";

        // Random float speed (6–12 seconds)
        cookie.style.animationDuration = (Math.random() * 6 + 6) + "s";

        document.body.appendChild(cookie);
    }

});
</script>


</body>
</html>
