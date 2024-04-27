
const loginForm = document.getElementById('login_form');

loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    loginFormSubmit();
});

async function loginFormSubmit() {
    let user={};
    user.username = document.getElementById('username').value;
    user.password = document.getElementById('password').value;
    user.rememberMe = document.getElementById('remember_me').checked;

    fetch('http://localhost:3000/user/login', {
        headers: {
            'Content-Type': 'application/json'
        },
        method: 'POST',
        body: JSON.stringify(user)
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