const registerForm = document.getElementById('registerForm');
registerForm.addEventListener('submit', (e) => {
    e.preventDefault();
    registerFormSubmit();
})

async function registerFormSubmit() {
    let user = {};
    user.full_name = document.getElementById('fullname').value;
    user.username = document.getElementById('username').value;
    user.email = document.getElementById('email').value;
    user.password = document.getElementById('password').value;
    user.role_id = document.getElementById('role_id').value;
    user.image = '/public/images/users/nf.jpg';

    fetch('http://localhost:3000/user/create', {
        method: 'POST',
        body: JSON.stringify(user),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡La inserción fue exitosa!');
            window.location.href = '/page/login';
        } else {
            alert('Error al insertar el usuario: ' + data.message);
        }
    })
    .catch(error => alert('Error en la solicitud:', error));

}
