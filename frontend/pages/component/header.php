<!-- Navigation Header -->
<header class="shadow-lg fixed top-0 w-full" style="background-color: #6e0d0aff;">
    <div class="max-w-50xl mx-auto px-7 sm:px-10 lg:px-20">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-3">
                <span class="text-3xl">🎄</span>
                <a href="../pages/home-page.php" class="text-2xl font-bold text-white">Bread Inventory System</a>
            </div>
            <nav class="flex space-x-8">
                <a href="../pages/home-page.php" id="nav-home" class="nav-link px-4 py-2 rounded-lg font-medium transition-colors duration-200 text-white hover:bg-white hover:text-amber-800">
                    Home
                </a>
                <a href="../pages/inventory-page.php" id="nav-inventory" class="nav-link px-4 py-2 rounded-lg font-medium transition-colors duration-200 text-white hover:bg-white hover:text-amber-800">
                    Inventory
                </a>
                <a href="../pages/sales-page.php" id="nav-sales" class="nav-link px-4 py-2 rounded-lg font-medium transition-colors duration-200 text-white hover:bg-white hover:text-amber-800">
                    Sales
                </a>
                <form action="../../../backend/auth/logout.php" method="POST" style="display: inline;">
                    <button type="submit" class="nav-link px-4 py-2 rounded-lg font-medium transition-colors duration-200 hover:bg-white hover:text-amber-800">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>
</header>