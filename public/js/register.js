const registerForm = document.getElementById('register_form');

registerForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    let user = new FormData(registerForm);

    fetch('/user/create', {
        method: 'POST',
        body: user
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.href = '/page/login';
        }
    });

});
