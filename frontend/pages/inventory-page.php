<?php
    require_once('../../backend/utils/db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetBrid Inventory System</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-full" style="background: url('../assets/img/christmas-bg.jpg') center/cover fixed no-repeat; background-color: #fff8e7;">
    <!-- Floating Background Icons -->
    <div class="floating-icon text-6xl">🍞</div>
    <div class="floating-icon text-5xl">🥖</div>
    <div class="floating-icon text-4xl">🥐</div>
    <div class="floating-icon text-6xl">🧁</div>
    <div class="floating-icon text-5xl">🍰</div>
    <div class="floating-icon text-4xl">🥯</div>
    <div class="floating-icon text-6xl">🍪</div>
    <div class="floating-icon text-5xl">🥨</div>
    <div class="floating-icon text-4xl">🍩</div>

   
        <!-- Nav header -->
        <?php include('./component/header.php');?>
        <!-- Toaster message -->
        <?php include('./component/toast.php');?>

        <!-- Inventory Page -->
        <div id="inventoryPage">
            <div class="max-w-7xl mx-auto px-4 py-8">
                <h2 class="text-3xl font-bold mb-8 text-center" style="color: #f1efecff;">Bread Inventory Management</h2>
                
                <!-- Add/Edit Form -->
                <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border-2 card-hover fade-in" style="border-color: #7a1f04ff;">
                    <h3 class="text-xl font-bold mb-4" style="color: #7a1f04ff;">Add New Bread Item</h3>
                    <form id="breadForm" class="grid md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: #8b5e3c;">Bread</label>
                            <input type="text" id="breadName" name="product-name" required class="w-full px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2" style="border-color: #d2a679; focus:ring-color #8b5e3c;">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: #8b5e3c;">Category</label>
                            <select id="breadCategory" name="category" class="w-full px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2" style="border-color: #d2a679;">
                                <!-- rendered via javascript -->
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: #8b5e3c;">Price (Php)</label>
                            <input type="number" id="breadPrice" name="price" step="0.01" required class="w-full px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2" style="border-color: #d2a679;">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: #8b5e3c;">Quantity</label>
                            <input type="number" id="breadQuantity" name="quantity" required class="w-full px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2" style="border-color: #d2a679;">
                        </div>
                        <div class="md:col-span-4 flex gap-4 mt-4">
                            <button type="submit" class="px-6 py-2 rounded-lg font-medium transition-colors duration-200 text-white hover:opacity-90" style="background-color: #7a1f04ff;">
                                ➕ Add Item
                            </button>
                            <button type="button" id="updateBtn" class="hidden px-6 py-2 rounded-lg font-medium transition-colors duration-200 text-white hover:opacity-90" style="background-color: #d2a679;">
                                ✏️ Update Item
                            </button>
                            <button type="button" id="cancelBtn" class="hidden px-6 py-2 rounded-lg font-medium transition-colors duration-200 text-white hover:opacity-90" style="background-color: #999;">
                                ❌ Cancel
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Search bar -->
<div class="bg-white p-4 rounded-xl shadow-lg mb-4 border-2 card-hover fade-in" style="border-color: #d2a679;">
                    <h3 class="text-lg font-bold mb-2" style="color: #8b5e3c;">Filter by Date & Search</h3>
                    <div class="flex gap-4 items-end flex-wrap">
                        <!-- Date Filters (Left Side) -->
                        <div class="flex gap-4 items-end">
                            <div>
                                <label class="block text-sm font-medium mb-1" style="color: #8b5e3c;">From Date</label>
                                <input type="date" id="filterFromDate" class="px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2" style="border-color: #d2a679;">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1" style="color: #8b5e3c;">To Date</label>
                                <input type="date" id="filterToDate" class="px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2" style="border-color: #d2a679;">
                            </div>
                            <button id="applyFilter" class="px-4 py-2 rounded-lg font-medium text-white transition-colors duration-200 hover:opacity-90" style="background-color: #8b5e3c;">
                                Apply Filter
                            </button>
                            <button id="clearFilter" class="px-4 py-2 rounded-lg font-medium text-white transition-colors duration-200 hover:opacity-90" style="background-color: #999;">
                                Clear Filter
                            </button>
                        </div>
                        <!-- Search Input (Right Side) -->
                        <div class="flex gap-2 items-end ml-auto">
                            <div>
                                <label class="block text-sm font-medium mb-1" style="color: #8b5e3c;">Search (Name/Category)</label>
                                <input type="text" id="searchInput" placeholder="e.g., Baguette" class="px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2" style="border-color: #d2a679;">
                            </div>
                            <button id="searchBtn" class="px-4 py-2 rounded-lg font-medium text-white transition-colors duration-200 hover:opacity-90" style="background-color: #8b5e3c;">
                                 Search
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Inventory Table -->
                <div class="bg-white rounded-xl shadow-lg border-2 overflow-hidden card-hover fade-in" style="border-color: #7a1f04ff;">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead style="background-color: #7a1f04ff;">
                                <tr>
                                    <th class="px-6 py-3 text-left text-white font-medium">Icon</th>
                                    <th class="px-6 py-3 text-left text-white font-medium">Name</th>
                                    <th class="px-6 py-3 text-left text-white font-medium">Category</th>
                                    <th class="px-6 py-3 text-left text-white font-medium">Price</th>
                                    <th class="px-6 py-3 text-left text-white font-medium">Quantity</th>
                                    <th class="px-6 py-3 text-left text-white font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="inventoryTable">
                                <!-- Items will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="pagination" class="flex justify-center items-center mt-4 space-x-1"></div>
            </div>
        </div>
        <!-- Footer -->
        <?php include('./component/footer.php');?>
    </div>

    <script type="module" src="../assets/js/sweetbrid.js"></script>
</body>
</html>