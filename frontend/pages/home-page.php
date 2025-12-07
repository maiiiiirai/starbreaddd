home page:
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santa's Inventory System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="min-h-full relative overflow-hidden"
      style="
        background-image: url('../assets/img/img1.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      ">

<script>
document.addEventListener("DOMContentLoaded", () => {
    for (let i = 0; i < 30; i++) { // more flakes
        let snow = document.createElement("div");
        snow.classList.add("snowflake");
        snow.innerHTML = "⭐";

        snow.style.left = Math.random() * 100 + "vw";
        
        // BIG RANDOM SIZE — from 25px to 50px
        const size = Math.random() * 25 + 25;
        snow.style.fontSize = size + "px";

        // Visible opacity between 0.7 — 1.0
        snow.style.opacity = Math.random() * 0.3 + 0.7;

        // Different speeds
        snow.style.animationDuration = (Math.random() * 4 + 4) + "s";

        document.body.appendChild(snow);
    }
});
</script>


    <div class="relative z-10">
        <!-- Header Component -->
        <?php include('./component/header.php');?>
       <!-- Home Page -->
    <div id="homePage" class="page">
    <div class="max-w-4xl mx-auto px-4 py-16 text-center">

   
        <!-- Rounded Welcome Box -->
        <div class="welcome-box">

            <span class="text-8xl mb-6 block"></span>

             <h1 class="text-5xl font-bold mb-6 outlined-text">
                Welcome to Santa's Bread Store
            </h1>

        </div>
        <!-- End Rounded Box -->

    </div>
    </div>
        <!-- Footer -->
        <?php include('./component/footer.php');?>
    </div>

    <script type="module" src="../assets/js/snowfall.js "></script>
    <script type="module" src="../assets/js/sweetbrid.js "></script>
</body>
</html>