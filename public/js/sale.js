const orderForm = document.getElementById('order-form');

orderForm.addEventListener('click', (e) => {
    e.preventDefault();
});

document.getElementById('submit-button').addEventListener('click', (e) => {
    e.preventDefault();
    sale();
});

function sale () {
    const data = new FormData(orderForm);

    fetch('/order/create', {
        method: 'POST',
        body: data
    })
    .then(Response => Response.json())
    .then(Data => {
        if (Data[0].success && Data[2].success ) {
            alert ('Compra realizada con éxito');
            window.location.href = "/page/user_profile";
        }
    });
}