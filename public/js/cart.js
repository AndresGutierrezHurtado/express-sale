document.addEventListener('DOMContentLoaded', () => {
    const addButtons = document.querySelectorAll('.btn-add-cart');
    const increaseButtons = document.querySelectorAll('.btn-increase');
    const decreaseButtons = document.querySelectorAll('.btn-decrease');
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const emptyButton = document.querySelector('#btn-empty');

    if (addButtons.length) {
        addButtons.forEach(button => {
            button.addEventListener('click', () => {

                let product = new FormData();
                product.append('producto_id', button.getAttribute('data-producto-id'));

                fetch('/cart/add', {
                    method: 'POST',
                    body: product
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    }
                })
            });
        });
    }

    if (increaseButtons.length) {
        increaseButtons.forEach(button => {
            button.addEventListener('click', () => {
                let product = new FormData();
                product.append('producto_id', button.getAttribute('data-producto-id'));
                product.append('action', 'increase');

                fetch(`/cart/update/`, { 
                    method: 'POST',
                    body: product
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
            });
        });
    }

    if (decreaseButtons.length) {
        decreaseButtons.forEach(button => {
            button.addEventListener('click', () => {
                let product = new FormData();
                product.append('producto_id', button.getAttribute('data-producto-id'));
                product.append('action', 'decrease');

                fetch(`/cart/update/`, { 
                    method: 'POST',
                    body: product
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
            });
        });
    }

    if (deleteButtons.length) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                if (confirm('¿Seguro que quieres eliminar este producto de tu carrito?')) {
                    let product = new FormData();
                    product.append('producto_id', button.getAttribute('data-producto-id'));

                    fetch(`/cart/delete/`, { 
                        method: 'POST',
                        body: product
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            window.location.reload();
                        }
                    })
                }
            });
        });
    }

    if (emptyButton) {
        emptyButton.addEventListener('click', () => {
            if (confirm('¿Seguro que quieres eliminar TODOS los productos de tu carrito?')) {
                fetch(`/cart/empty/`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    }
                })
            }
        });
    }
});
