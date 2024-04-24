const logoutButton = document.getElementById('btn-logout');
const editButton = document.getElementById('btn-edit');
const submitButton = document.getElementById('btn-submit');
const userProfileForm = document.getElementById('user_profile');
const inputs = document.querySelectorAll('input[disabled]');
let editable = false;

logoutButton.addEventListener('click', () => {
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
    } else {
        if (confirm('¿deseas cancelar?, perderás todos los cambios.')){
            editButton.innerHTML = 'Editar';
            window.location.reload();
            return;
        } 
    }
    submitButton.classList.toggle('hidden');
    document.getElementById('image').classList.toggle('hidden');
    inputs.forEach(input => {
        input.disabled = editable;
    })
    editable = !editable    
})

userProfileForm.addEventListener('submit', (e) => {
    e.preventDefault();
    UpdateProfile();
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
    } else {
        user.append('image', '/public/images/users/nf.jpg');
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

