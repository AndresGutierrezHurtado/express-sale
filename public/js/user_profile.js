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
        document.querySelectorAll('input[disabled]').forEach(input => {
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

document.getElementById('user_profile').addEventListener('submit', (e) => {
    e.preventDefault();
    UpdateProfile();
})

document.getElementById('new-product-form').addEventListener('submit', (e) => {
    e.preventDefault();
    newProduct();
})

async function UpdateProfile() {
    let user = new FormData();
    user.append('user_id', parseInt(document.getElementById('user_id').value));
    user.append('full_name', document.getElementById('full_name').value);
    user.append('username', document.getElementById('username').value);
    user.append('email', document.getElementById('email').value);
    user.append('address', document.getElementById('address').value);
    user.append('phone_number', parseInt(document.getElementById('phone_number').value));
    
    // Verificar si se ha seleccionado una imagen
    if (document.getElementById('image').files.length > 0) {
        user.append('image', document.getElementById('image').files[0]);
    }

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

async function newProduct() {
    let product = new FormData();

    product.append('user_id', parseInt(document.getElementById('user_id').value));
    product.append('name', document.getElementById('name').value);
    product.append('description', document.getElementById('description').value);
    product.append('price', parseFloat(document.getElementById('price').value));
    product.append('stock', parseInt(document.getElementById('stock').value));
    product.append('category_id', parseInt(document.getElementById('category').value));
    product.append('state', document.getElementById('state').value);
    product.append('image', '/public/images/products/nf.jpg');
    product.append('calification', '0');

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


