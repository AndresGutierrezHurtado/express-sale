const registerForm = document.getElementById('registerForm');
registerForm.addEventListener('submit', (e) => {
    e.preventDefault();
    registerFormSubmit();
})

async function registerFormSubmit() {
    let cliente = {};
    cliente.full_name = document.getElementById('fullname').value;
    cliente.username = document.getElementById('username').value;
    cliente.email = document.getElementById('email').value;
    cliente.password = document.getElementById('password').value;
    cliente.image = '/public/images/users/nf.jpg';
    cliente.role_id = 1;
    cliente.account_type = 1;

    fetch('http://localhost:3000/user/create', {
        method: 'POST',
        body: JSON.stringify(cliente),
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
