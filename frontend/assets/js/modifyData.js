export const editState = { id: null };

// Edit product function
export async function editItem(id) {
    try {
        const response = await fetch(`../../backend/inventory/getProductById.php?id=${id}`);
        const { product, category, price, quantity } = await response.json();

        document.getElementById('breadName').value = product;
        document.getElementById('breadCategory').value = category;
        document.getElementById('breadPrice').value = price;
        document.getElementById('breadQuantity').value = quantity;

        editState.id = id;
        document.querySelector('button[type="submit"]').classList.add('hidden');
        document.getElementById('updateBtn').classList.remove('hidden');
        document.getElementById('cancelBtn').classList.remove('hidden');

    } catch (error) {
        console.error('An error occurred: ', error.message);
    }
}

// Cancel edit function
export function cancelEdit() {
    const form = document.getElementById('breadForm');
    form.reset();

    editState.id = null;

    // hide update and cancel buttons
    document.getElementById('updateBtn').classList.add('hidden');
    document.getElementById('cancelBtn').classList.add('hidden');

    // show the add item (submit) button again
    document.querySelector('button[type="submit"]').classList.remove('hidden');
}