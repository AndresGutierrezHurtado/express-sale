const editButton = document.getElementById('btn-edit');
let editable = false;

document.getElementById('btn-logout').addEventListener('click', () => {
    if (confirm('¿Estás seguro que quieres cerrar sesión?')) {
        fetch('/user/log_out')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = '/';
            } else {
                alert('hubo un problema.');
            }
        });
    }
});

editButton.addEventListener('click', (e) => {
    e.preventDefault();
    if (!editable){
        editButton.innerHTML = 'Cancelar';
        document.getElementById('btn-submit').classList.toggle('hidden');
        document.getElementById('image').classList.toggle('hidden');
        document.querySelectorAll('[disabled]').forEach(input => {
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

document.getElementById('user_profile_form').addEventListener('submit', (e) => {
    e.preventDefault();
    UpdateProfile();
})

async function UpdateProfile() {
    let user = new FormData(document.getElementById('user_profile_form'));
    
    await fetch('/user/update', {
        method: 'POST',
        body: user
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.reload();
        }
    })
}

document.getElementById('new-product-form').addEventListener('submit', (e) => {
    e.preventDefault();
    newProduct();
})

async function newProduct() {
    let product = new FormData(document.getElementById('new-product-form'));
    
    var currentDate = new Date();
    var formattedDate = currentDate.toISOString().split('T')[0];
    
    product.append('product_date', formattedDate);

    await fetch('/product/create', {
        method: 'POST',
        body: product
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.reload();
        }
    })

}


