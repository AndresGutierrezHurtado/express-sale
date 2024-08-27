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
        if (data.success) {
            alert(data.message);
            window.location.href = '/page/login';
        } else {
            alert(data.error);
        }
    });

});
