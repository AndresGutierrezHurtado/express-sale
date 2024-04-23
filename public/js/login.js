
const loginForm = document.getElementById('login_form');

loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    loginFormSubmit();
});

async function loginFormSubmit() {
    let cliente={};
    cliente.username = document.getElementById('username').value;
    cliente.password = document.getElementById('password').value;
    cliente.rememberMe = document.getElementById('remember_me').checked;

    fetch('http://localhost:3000/user/autenticate', {
        method: 'POST',
        body: JSON.stringify(cliente),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡El inicio de sesión fue existoso!');
            window.location.href = '/';
        } else {
            alert('Error al ingresar el usuario: ' + data.message);
        }
    })

}