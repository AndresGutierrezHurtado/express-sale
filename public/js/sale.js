const saleForm = document.getElementById('sale-form');

saleForm.addEventListener('click', (e) => {
    e.preventDefault();
});

document.getElementById('submit-button').addEventListener('click', (e) => {
    e.preventDefault();
    sale();
});

function sale () {
    const data = new FormData(saleForm);

    fetch('/sale/create', {
        method: 'POST',
        body: data
    })
    .then(Response => Response.json())
    .then(Data => {
        alert(Data.message);
        if (Data.success) {
            window.location.href = "/page/user_profile"
        }   
    });
}