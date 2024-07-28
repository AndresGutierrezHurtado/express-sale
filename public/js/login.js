const loginForm = document.getElementById('login_form');

loginForm.addEventListener('submit', (e) => {
    e.preventDefault();

    let user = new FormData(loginForm);

    fetch('/user/login', {
        method: 'POST',
        body: user
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
});