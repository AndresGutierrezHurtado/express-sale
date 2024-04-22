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
        body: JSON.stringify(cliente)
    })
    .then(data => {
        if (data.success) {       
            alert(data.message);
        } else {    
            alert(data.message);
        }
    })
    .catch(error => console.error('Error en la solicitud:', error));

}