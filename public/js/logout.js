const logoutButton = document.getElementById('logout-btn');

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