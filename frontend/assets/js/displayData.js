import { getProductIcon } from '../utils/mapper.js';
import { editItem, cancelEdit} from './modifyData.js';
import { globalListener } from '../utils/globalListener.js';

let currentPage = 1;
const limit = 5;
const tbody = document.querySelector('tbody');
const applyFilterBtn = document.getElementById('applyFilter');
const clearFilterBtn = document.getElementById('clearFilter');
const filterFromDate = document.getElementById('filterFromDate');
const filterToDate = document.getElementById('filterToDate');
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');

// simple debounce helper
function debounce(fn, delay = 300) {
    let t;
    return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn.apply(this, args), delay);
    };
}

tbody.addEventListener('click', (e) => {
    const btn = e.target.closest('button');
    if (!btn) return;
  
    const action = btn.dataset.action;
    const id = btn.dataset.id;
    if (action === 'edit') editItem(id);         
    if (action === 'delete') deleteItem(id);     
});

async function renderInventory(page = 1, fromDate = null, toDate = null, search = null) {
    let url = `../../../backend/inventory/getProducts.php?page=${page}&limit=${limit}`;

    if (fromDate) url += `&from_date=${fromDate}`;
    if (toDate) url += `&to_date=${toDate}`;
    if (search) url += `&search=${encodeURIComponent(search)}`;
    
    try {
        const response = await fetch(url);
        const data = await response.json(); 
        const inventoryData = data.products;
        let html = '';

        inventoryData.forEach(item => {
            const row = `
                <tr>
                    <td class="border-b hover:bg-gray-50 px-6 py-4 text-2xl animate-bounce">${getProductIcon(item.product)}</td>
                    <td class="border-b hover:bg-gray-50 px-6 py-4 font-medium" style="color: #8b5e3c;">${item.product}</td>
                    <td class="border-b hover:bg-gray-50 px-6 py-4" style="color: #8b5e3c;">${item.category}</td>
                    <td class="border-b hover:bg-gray-50 px-6 py-4" style="color: #8b5e3c;">₱${parseFloat(item.price).toFixed(2)}</td>
                    <td class="border-b hover:bg-gray-50 px-6 py-4 ${item.quantity <= 5 ? 'text-red-600 font-bold' : ''}" style="color: ${item.quantity <= 5 ? '#dc2626' : '#8b5e3c'};">${item.quantity}</td>
                    <td class="border-b hover:bg-gray-50 px-6 py-4">
                        <div class="flex space-x-2">
                            <button type="button" data-action="edit" data-id="${item.id}" class="p-2 rounded-lg text-white hover:opacity-90 hover:scale-105 transform transition-all duration-200 shadow-md hover:shadow-lg" style="background-color: #3b82f6;" title="Edit Item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button data-action="delete" data-id="${item.id}" class="p-2 rounded-lg text-white hover:opacity-90 hover:scale-105 transform transition-all duration-200 shadow-md hover:shadow-lg" style="background-color: #ef4444;" title="Delete Item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            html += row;
        });
        tbody.innerHTML = html;
        renderPagination(data.totalPages, data.currentPage, fromDate, toDate, search);

    } catch (error) {
        console.error('Error fetching inventory:', error);
    }
}

// Render pagination buttons
function renderPagination(totalPages, currentPage) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    // Prev Button
    const prevBtn = document.createElement('button');
    prevBtn.textContent = 'Prev';
    prevBtn.disabled = currentPage === 1;
    prevBtn.className = 'px-3 py-1 mx-1 rounded bg-gray-200 hover:bg-gray-300 disabled:opacity-50';
    prevBtn.addEventListener('click', () => renderInventory(currentPage - 1));
    paginationContainer.appendChild(prevBtn);

    // Page Numbers
    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.className = `px-3 py-1 mx-1 rounded ${i === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300'}`;
        btn.addEventListener('click', () => renderInventory(i));
        paginationContainer.appendChild(btn);
    }

    // Next Button
    const nextBtn = document.createElement('button');
    nextBtn.textContent = 'Next';
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.className = 'px-3 py-1 mx-1 rounded bg-gray-200 hover:bg-gray-300 disabled:opacity-50';
    nextBtn.addEventListener('click', () => renderInventory(currentPage + 1));
    paginationContainer.appendChild(nextBtn);
}

// delete product function
async function deleteItem(id) {
    const confirmDelete = confirm("Are you sure you want to delete this item?");
    if (!confirmDelete) return;

    try {
        const response = await fetch(`../../backend/inventory/deleteProduct.php?id=${id}`, {
            method: 'DELETE'
        });
        const { success, error } = await response.json();

        if (success) {
            const toast = document.getElementById('successMessage');
            const toastText = document.getElementById('successText');

            toastText.textContent = "Item deleted successfully!";
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 2500);

            // re-display the inventory data
            renderInventory(currentPage);
        } else {
            alert(error || "Failed to delete item.");
        }
    } catch (error) {
        console.error("Error deleting item:", error);
    }
}

const cancelBtn = document.querySelector('#cancelBtn');
globalListener('click', cancelBtn, cancelEdit);

globalListener('click', applyFilterBtn, () => {
    const fromDate = filterFromDate.value;
    const toDate = filterToDate.value;
    renderInventory(1, fromDate, toDate);
});
globalListener('click', clearFilterBtn, () => {
    filterFromDate.value = '';
    filterToDate.value = '';
    renderInventory(1);
});
globalListener('click', searchBtn, () => {
    const fromDate = filterFromDate.value;
    const toDate = filterToDate.value;
    const search = searchInput.value.trim();
    renderInventory(1, fromDate, toDate, search);
});
searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        searchBtn.click();
    }
});


// Wire up search input to re-render inventory (debounced)
if (searchInput) {
    const onSearch = debounce(() => {
        currentPage = 1;
        renderInventory(1);
    }, 300);
    searchInput.addEventListener('input', onSearch);
}

// Clear button
const searchClearBtn = document.getElementById('searchClearBtn');
if (searchClearBtn) {
    searchClearBtn.addEventListener('click', () => {
        if (searchInput) {
            searchInput.value = '';
            currentPage = 1;
            renderInventory(1);
            searchInput.focus();
        }
    });
}

export default renderInventory;