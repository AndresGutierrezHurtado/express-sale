const logoutButton = document.getElementById('btn-logout');
const editButton = document.getElementById('btn-edit');
const submitButton = document.getElementById('btn-submit');
const userProfileButton = document.getElementById('user_profile');
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
    inputs.forEach(input => {
        input.disabled = editable;
    })
    editable = !editable    
})

userProfileButton.addEventListener('submit', (e) => {
    e.preventDefault();
    UpdateProfile();
})
async function UpdateProfile() {
    let user = {};
    user.user_id = document.getElementById('user_id').value;
    user.full_name = document.getElementById('full_name').value;
    user.username = document.getElementById('username').value;
    user.email = document.getElementById('email').value;
    user.address = document.getElementById('address').value;
    user.phone_number = document.getElementById('phone_number').value;
    user.image = document.getElementById('image');
    
    fetch('/user/update', {
    headers: {
        'Content-Type': 'application/json'
    },
    method: 'POST',
    body: JSON.stringify(user)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message)
            window.location.reload();
        } else {
            alert(data.message)
            window.location.reload();
        }
    })
    
}

