document.addEventListener('DOMContentLoaded', () => {
    const addButtons = document.querySelectorAll('.btn-add-cart');
    const increaseButtons = document.querySelectorAll('.btn-increase');
    const decreaseButtons = document.querySelectorAll('.btn-decrease');
    const deleteButtons = document.querySelectorAll('.btn-delete');

    // Agregar al carrito
    addButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (button.getAttribute('data-session') == "false") {                
                if (confirm('para realizar esta acción tienes que iniciar sesión')){
                    window.location.href = '/page/login'
                }
            } else {
                console.log()
                
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
                    if (Data.success) {
                        console.log('Producto agregado correctamente.');
                    }
                })   
            }         
        })
    })

    increaseButtons.forEach(button => {
        button.addEventListener('click', () => {
            let product = new FormData();
            product.append('id', button.getAttribute('data-id'));
            product.append('action', 'increase');

            fetch(`/cart/update/`, { 
                method: 'POST',
                body: product
            })
            .then(Response => Response.json())
            .then(Data => {
                if (Data.success) {
                    console.log(Data.cart);
                    window.location.reload();
                }
            });
        });
    });

    // Disminuir cantidad de un producto en el carrito
    decreaseButtons.forEach(button => {
        button.addEventListener('click', () => {
            let product = new FormData();
            product.append('id', button.getAttribute('data-id'));
            product.append('action', 'decrease');

            fetch(`/cart/update/`, { 
                method: 'POST',
                body: product
            })
            .then(Response => Response.json())
            .then(Data => {
                if (Data.success) {
                    console.log(Data.cart);
                    window.location.reload();
                }
            });
        });
    });
    
    // Eliminar un producto del carrito
    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (confirm('¿seguro que quieres eliminar este producto de tu carrito?')) {
                let product = new FormData();
                product.append('id', button.getAttribute('data-id'));

                fetch(`/cart/delete/`, { 
                    method: 'POST',
                    body: product
                })
                .then(response => response.json())
                .then(Data => {
                    if (Data.success) {
                        console.log(Data.cart);
                        window.location.reload();
                    }
                });
            }
        });
    });

    document.querySelector('#btn-empty').addEventListener('click', () => {
        if (confirm('¿seguro que quieres eliminar TODOS los productos de tu carrito?')) {
            fetch(`/cart/empty/`)
            .then(response => response.json())
            .then(Data => {
                if (Data.success) {
                    console.log(Data.cart);
                    window.location.reload();
                }
            });
        }

    })
    
})