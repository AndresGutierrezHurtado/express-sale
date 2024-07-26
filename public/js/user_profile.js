const editButton = document.getElementById('btn-edit');
let editable = false;

// Botón cerrar sesión
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

// Botón editar sesión
editButton.addEventListener('click', (e) => {
    e.preventDefault();
    if (!editable){
        editButton.innerHTML = `
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fa-solid fa-x text-[17px] text-gray-300 duration-300 group-hover:text-gray-500"></i>
            </span>
            Cancelar
        `;
      
        document.getElementById('btn-submit').classList.toggle('hidden');
        document.getElementById('usuario_imagen').classList.toggle('hidden');
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

// user_profile
document.getElementById('user_profile_form').addEventListener('submit', (e) => {
    e.preventDefault();

    let user = new FormData(document.getElementById('user_profile_form'));
    
    fetch('/user/update', {
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
});

// logica para la inserción de un nuevo producto
document.getElementById('new-product-form').addEventListener('submit', (e) => {
    e.preventDefault();

    let product = new FormData(document.getElementById('new-product-form'));
    
    fetch('/product/create', {
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

});