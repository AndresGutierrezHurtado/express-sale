const editButton = document.getElementById('btn-edit');
const submitButton = document.getElementById('btn-submit');
const productProfileForm = document.getElementById('product_profile_form');
const inputs = document.querySelectorAll('[disabled]');
let editable = false;

// logica para el botón de edición
editButton.addEventListener('click', (e) => {
    e.preventDefault();
    if (!editable){
        editButton.innerHTML = `
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fa-solid fa-x text-[17px] text-gray-300 duration-300 group-hover:text-gray-500"></i>
            </span>
            Cancelar
        `;

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

// logica para actualización de datos
productProfileForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    let productData = new FormData(productProfileForm);
    
    fetch('/product/update', {
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

});
