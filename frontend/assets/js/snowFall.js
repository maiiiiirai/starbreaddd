 const floatingIcons = document.querySelectorAll('.floating-icon');
        floatingIcons.forEach(icon => {
            icon.style.left = Math.random() * 100 + "vw";
            icon.style.top = Math.random() * 100 + "vh";
            icon.style.animationDuration = 6 + Math.random() * 6 + "s";
        });

        // GENERATE SNOWFLAKES
        const snowCount = 30;

        for (let i = 0; i < snowCount; i++) {
            let snow = document.createElement("div");
            snow.className = "snowflake";
                
            snow.innerHTML = "❄️ ";

            snow.style.left = Math.random() * window.innerWidth + "px";
            // Random snowflake size: small, medium, large
    const sizes = [30, 40, 50]; // small, medium, large
    snow.style.fontSize = sizes[Math.floor(Math.random() * sizes.length)] + "px";

            snow.style.animationDuration = (3 + Math.random() * 5) + "s";
            snow.style.opacity = 0.5 + Math.random() * 0.5;

            document.body.appendChild(snow);

            snow.addEventListener("animationiteration", () => {
                snow.style.left = Math.random() * window.innerWidth + "px";
            });

        }

        