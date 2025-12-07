import animateIcons from "./animation.js";
import { getProductIcon } from '../utils/mapper.js';
import { globalListener } from '../utils/globalListener.js';
import { icons } from '../data/data.js';
import renderInventory from "./displayData.js";
import { editState } from "./modifyData.js";

animateIcons();
renderInventory();

editState.id = null;

document.addEventListener('DOMContentLoaded', () => {
    const breadCategory = document.getElementById('breadCategory');
  
    icons.forEach(icon => {
        icon.names.forEach(name => {
            const option = `<option value="${name}">${icon.icon} ${name}</option>`;
            breadCategory.innerHTML += option;
        });
    });
   
    globalListener('change', breadCategory, (e) => {
        const selectedValue = e.target.value;
        const icon = getProductIcon(selectedValue);
        console.log(`Selected: ${selectedValue} -> ${icon}`);
    });
});

// handle adding product or updating product dynamically
// if the editingId variable is 'null', then POST request is sent to the backend
// if the editingId variable is not 'null', then PUT request is sent to the backend
async function handleSubmitOrUpdate(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    const data = {
        product: formData.get('product-name'),
        category: formData.get('category'),
        price: formData.get('price'),
        quantity: formData.get('quantity')
    };

    if (!data.product || !data.category || !data.price || !data.quantity) return;

    try {
        const isEditing = editState.id !== null;
        const url = isEditing
            ? `../../backend/inventory/updateProduct.php?id=${editState.id}`
            : `../../backend/inventory/create_products.php`;

        const method = isEditing ? 'PUT' : 'POST';

        const response = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const { success, message } = await response.json();

        if (success) {
            const toast = document.getElementById('successMessage');
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 2000);

            form.reset();
            editState.id = null;

            document.getElementById('updateBtn').classList.add('hidden');
            document.getElementById('cancelBtn').classList.add('hidden');
            document.querySelector('button[type="submit"]').classList.remove('hidden');

            await renderInventory();
        }

        return { success, message };

    } catch (error) {
        console.error('An error occurred:', error.message);
    }
}

const breadForm = document.getElementById('breadForm');
const updateBtn = document.getElementById('updateBtn');

globalListener('submit', breadForm, (e) => {
    handleSubmitOrUpdate(e);
});

// forcing the update btn to use submit type when clicked
updateBtn.addEventListener('click', (e) => {
    e.preventDefault();
    breadForm.dispatchEvent(new Event('submit', { cancelable: true }));
});