document.addEventListener('DOMContentLoaded', () => {
    fetchTotalSales();
    fetchTotalItems();
    fetchLowStock();
    populateDropdown();

    document.getElementById('processSaleBtn').addEventListener('click', processSale);
});

// get total sales
async function fetchTotalSales() {
    try {
        const response = await fetch('../../backend/sales/countSales.php');
        const data = await response.json();
        const total = parseFloat(data.totalSales || 0).toFixed(2);
        document.getElementById('totalSales').textContent = `$${total}`;
    } catch (error) {
        console.error('Error fetching total sales:', error);
    }
}

// gwet total items
async function fetchTotalItems() {
    try {
        const response = await fetch('../../backend/sales/countItems.php');
        const data = await response.json();
        document.getElementById('totalItems').textContent = data.totalItems || 0;
    } catch (error) {
        console.error('Error fetching total items:', error);
    }
}

// get low stock items
async function fetchLowStock() {
    try {
        const response = await fetch('../../backend/sales/countLowStocks.php');
        const data = await response.json();

        document.getElementById('lowStockCount').textContent = data.count || 0;

        const alertContainer = document.getElementById('lowStockList');
        alertContainer.innerHTML = '';

        if (data.lowStock && data.lowStock.length > 0) {
            data.lowStock.forEach(item => {
                const alertDiv = document.createElement('div');
                alertDiv.className = "flex justify-between items-center bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded-md mt-2";
                alertDiv.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <span>🍰</span>
                        <span>${item.product}</span>
                    </div>
                    <span class="font-semibold">${item.quantity} left</span>
                `;
                alertContainer.appendChild(alertDiv);
            });
        } else {
            alertContainer.innerHTML = `<p class="text-gray-500 italic">No low-stock items.</p>`;
        }
    } catch (error) {
        console.error('Error fetching low stock:', error);
    }
}

// show products that can be sold in the dropdown based on the available products in tbl_products
async function populateDropdown() {
    try {
        const response = await fetch('../../backend/sales/getProductList.php');
        const products = await response.json();
        const dropdown = document.getElementById('saleProductSelect');
        dropdown.innerHTML = `<option value="">Select item to sell</option>`;

        products.forEach(p => {
            const option = document.createElement('option');
            option.value = p.id;
            option.textContent = p.product;
            dropdown.appendChild(option);
        });
    } catch (error) {
        console.error('Error loading dropdown:', error);
    }
}

// process sale function
async function processSale() {
    const productId = document.getElementById('saleProductSelect').value;
    const quantity = document.getElementById('saleQuantity').value;

    if (!productId || !quantity) {
        alert('Please select a product and enter a quantity.');
        return;
    }

    try {
        const response = await fetch('../../backend/sales/processSale.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ product_id: productId, quantity_sold: quantity })
        });

        const data = await response.json();

        if (data.success) {
            const toast = document.getElementById('successMessage');
            const toastText = document.getElementById('successText');

            toastText.textContent = "Purchase Successfull!";
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 2500);

            document.getElementById('saleQuantity').value = '';
            
            // refresh the total count status
            fetchTotalSales();
            fetchTotalItems();
            fetchLowStock();
        } else {
            alert(` ${data.message}`);
        }
    } catch (error) {
        console.error('Error processing sale:', error);
    }
}