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
                product.append('product_id', button.getAttribute('data-product_id'));
                product.append('seller_id', button.getAttribute('data-seller_id'));
                product.append('product_name', button.getAttribute('data-product_name'));
                product.append('product_price', button.getAttribute('data-product_price'));
                product.append('product_address', button.getAttribute('data-product_address'));
                product.append('product_image', button.getAttribute('data-product_image'));

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
            product.append('product_id', button.getAttribute('data-product_id'));
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
            product.append('product_id', button.getAttribute('data-product_id'));
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
                product.append('product_id', button.getAttribute('data-product_id'));

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