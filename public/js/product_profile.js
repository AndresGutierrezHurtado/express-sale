const editButton = document.getElementById('btn-edit');
const submitButton = document.getElementById('btn-submit');
const productProfileForm = document.getElementById('product_profile');
const inputs = document.querySelectorAll('[disabled]');
let editable = false;

editButton.addEventListener('click', (e) => {
    e.preventDefault();
    if (!editable){
        editButton.innerHTML = 'Cancelar';
        submitButton.classList.toggle('hidden');
        document.getElementById('image').classList.toggle('hidden');
        inputs.forEach(input => {
            input.disabled = editable;
        })
        editable = !editable    
    } else {
        if (confirm('¿deseas cancelar?, perderás todos los cambios.')){
            editButton.innerHTML = 'Editar';
            window.location.reload();
            
        }
    }
})

productProfileForm.addEventListener('submit', (e) => {
    e.preventDefault();
    UpdateProfile();
})

async function UpdateProfile() {
    let productData = new FormData();
    productData.append('id', parseInt(document.getElementById('product').value));
    productData.append('name', document.getElementById('name').value);
    productData.append('description', document.getElementById('description').value);
    productData.append('price', parseFloat(document.getElementById('price').value));
    productData.append('stock', parseInt(document.getElementById('stock').value));
    productData.append('category_id', document.getElementById('category').value);

    // Verificar si se ha seleccionado una imagen
    if (document.getElementById('image').files.length > 0) {
        productData.append('image', document.getElementById('image').files[0]);
    } else {
        productData.append('image', '/public/images/products/nf.jpg');
    }
    
    await fetch('/product/update', {
        method: 'POST',
        body: productData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.reload();
        }
    })

}

