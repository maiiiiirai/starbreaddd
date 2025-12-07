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
    
        <!-- Sales Page -->
        <div id="salesPage">
            <div class="max-w-6xl mx-auto px-4 py-8">
                <h2 class="text-3xl font-bold mb-8 text-center" style="color: #f1efecff;">Sales & Progress Tracker</h2>
                
                <!-- Sales Summary Cards -->
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-lg border-2 card-hover pulse-glow" style="border-color: #d2a679;">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium" style="color: #8b5e3c;">Total Sales</p>
                                <p class="text-3xl font-bold" style="color: #8b5e3c;" id="totalSales">₱0.00</p>
                            </div>
                            <span class="text-4xl animate-bounce">💰</span>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg border-2 card-hover" style="border-color: #d2a679;">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium" style="color: #8b5e3c;">Total Items</p>
                                <p class="text-3xl font-bold" style="color: #8b5e3c;" id="totalItems">0</p>
                            </div>
                            <span class="text-4xl rotate-on-hover">📦</span>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg border-2 card-hover" style="border-color: #d2a679;">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium" style="color: #8b5e3c;">Low Stock Items</p>
                                <p class="text-3xl font-bold text-red-600" id="lowStockCount">0</p>
                            </div>
                            <span class="text-4xl animate-pulse">⚠️</span>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white rounded-xl shadow-lg border-2 mb-8" style="border-color: #d2a679;">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-4" style="color: #8b5e3c;">⚠️ Low Stock Alert (Quantity ≤ 5)</h3>
                        <div id="lowStockList" class="space-y-2">
                            <!-- Low stock items will be populated here -->
                        </div>
                    </div>
                </div>

                <!-- Sales Simulator -->
                <div class="bg-white rounded-xl shadow-lg border-2" style="border-color: #d2a679;">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-4" style="color: #8b5e3c;">📊 Sales Simulator</h3>
                        <p class="mb-4" style="color: #8b5e3c;">Simulate sales to see how your inventory changes</p>
                        <div class="grid md:grid-cols-3 gap-4">
                            <select id="saleProductSelect" class="px-3 py-2 border-2 rounded-lg" style="border-color: #d2a679;">
                                <option value="">Select item to sell</option>
                            </select>
                            <input type="number" id="saleQuantity" placeholder="Quantity to sell" min="1" class="px-3 py-2 border-2 rounded-lg" style="border-color: #d2a679;">
                            <button id="processSaleBtn" class="px-6 py-2 rounded-lg font-medium text-white transition-colors duration-200 hover:opacity-90" style="background-color: #8b5e3c;">
                                💳 Process Sale
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <?php include('./component/footer.php');?>
    </div>

    <script type="module" src="../assets/js/sweetbrid-sales.js"></script>
</body>
</html>