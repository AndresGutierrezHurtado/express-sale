const editButton = document.getElementById('btn-edit');
const submitButton = document.getElementById('btn-submit');
const productProfileForm = document.getElementById('product_profile_form');
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
    let productData = new FormData(productProfileForm);
    
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

