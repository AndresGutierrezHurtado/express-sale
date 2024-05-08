const sellerStars = document.querySelectorAll('.starVendedor');
const sellerButton = document.getElementById('calificar-btn-vendedor');

const productStars = document.querySelectorAll('.starProducto');
const productButton = document.getElementById('calificar-btn-producto');

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

productButton.addEventListener('click' , (e) => {
    e.preventDefault();

    let product = productButton.dataset.product_id;
    let currentRating = productButton.dataset.product_rating;
    let votes = parseInt(productButton.dataset.product_votes);
    
    let newRating = ((currentRating * votes) + parseInt(document.querySelector('.starProducto.selected').dataset.value)) / (votes + 1);
    
    let formData = new FormData();
    
    formData.append('product_id', product);
    formData.append('product_votes',  votes + 1);
    formData.append('product_rating', newRating);
    
    fetch('/product/update/', {
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

sellerButton.addEventListener('click' , (e) => {
    e.preventDefault();

    let user = sellerButton.dataset.seller_id;
    let votes = parseInt(sellerButton.dataset.seller_votes);
    let currentRating = sellerButton.dataset.seller_rating;
    
    let newRating = ((currentRating * votes) + parseInt(document.querySelector('.starVendedor.selected').dataset.value)) / (votes + 1);
    
    let formData = new FormData();
    
    formData.append('seller_id', user);
    formData.append('seller_votes',  votes + 1);
    formData.append('seller_rating', newRating);
    
    fetch('/seller/update/', {
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