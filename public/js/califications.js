const sellerStars = document.querySelectorAll('.starVendedor');
const sellerButton = document.getElementById('calificar-btn-vendedor');

const productStars = document.querySelectorAll('.starProducto');
const productButton = document.getElementById('calificar-btn-producto');

// logica estrellas vendedor
sellerStars.forEach(star => {
    star.addEventListener('click', () => {
        const value = parseInt(star.dataset.value);

        if (star.classList.contains('selected')) {
            sellerStars.forEach(s => {
                s.innerHTML = '<i class="far fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"></i>';
                s.classList.remove('selected');
                sellerButton.classList.remove('hidden');
            });
        } else {
            sellerStars.forEach((s, index) => {
                if (index < value) {
                    s.innerHTML = '<i class="fas fa-star cursor-pointer text-amber-400 duration-300 hover:scale-[1.15]"></i>';
                    s.classList.remove('selected');
                } else {
                    s.innerHTML = '<i class="far fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"></i>';
                    s.classList.remove('selected');
                }
            });
            star.classList.add('selected');
        }

        const anySelected = Array.from(sellerStars).some(s => s.classList.contains('selected'));
        sellerButton.classList.toggle('hidden', !anySelected);
    });
});

// logica estrellas producto
productStars.forEach(star => {
    star.addEventListener('click', () => {
        const value = parseInt(star.dataset.value);

        if (star.classList.contains('selected')) {
            productStars.forEach(s => {
                s.innerHTML = '<i class="far fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"></i>';
                s.classList.remove('selected');
                productButton.classList.remove('hidden');
            });
        } else {
            productStars.forEach((s, index) => {
                if (index < value) {
                    s.innerHTML = '<i class="fas fa-star cursor-pointer text-amber-400 duration-300 hover:scale-[1.15]"></i>';
                    s.classList.remove('selected');
                } else {
                    s.innerHTML = '<i class="far fa-star cursor-pointer text-amber-600 duration-300 hover:scale-[1.15]"></i>';
                    s.classList.remove('selected');
                }
            });
            star.classList.add('selected');
        }

        const anySelected = Array.from(productStars).some(s => s.classList.contains('selected'));
        productButton.classList.toggle('hidden', !anySelected);
    });
});

// logica fetch producto
document.getElementById('rating-form-producto').addEventListener('submit' , (e) => {
    e.preventDefault();

    let formData = new FormData();
    
    formData.append('calification_object_type', 'producto');
    formData.append('calification_comment', document.getElementById('calification-comment-product').value);
    formData.append('calification', parseInt(document.querySelector('.starProducto.selected').dataset.value));
    formData.append('calificator_user_id',  document.getElementById('calificar-btn-producto').dataset.calificator_user_id )
    formData.append('calificated_object_id', document.getElementById('calificar-btn-producto').dataset.calificated_object_id );
    
    fetch('/calification/rate', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.reload();
        }
    })
});

// logica fetch vendedor
document.getElementById('rating-form-vendedor').addEventListener('submit' , (e) => {
    e.preventDefault();

    let formData = new FormData();
    
    formData.append('calification_object_type', 'usuario');
    formData.append('calification_comment', document.getElementById('calification-comment-user').value);
    formData.append('calification', parseInt(document.querySelector('.starVendedor.selected').dataset.value));
    formData.append('calificator_user_id',  document.getElementById('calificar-btn-vendedor').dataset.calificator_user_id );
    formData.append('calificated_object_id', document.getElementById('calificar-btn-vendedor').dataset.calificated_object_id );
    
    fetch('/calification/rate', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.reload();
        }
    })
});