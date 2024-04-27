document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.btn-add-cart');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            let product = new FormData();
            product.append('id', button.getAttribute('data-id'));
            product.append('name', button.getAttribute('data-name'));
            product.append('price', button.getAttribute('data-price'));
            product.append('image', button.getAttribute('data-image'));

            fetch('/cart/add', {
                method: 'POST',
                body: product
            })
            .then(Response => Response.json())
            .then(Data => {
                console.log(Data.cart);
            })            
        })
    })
})