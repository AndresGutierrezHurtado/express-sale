document.addEventListener('DOMContentLoaded', () => {
    // Selecciona todos los elementos de estrellas
    const productStars = document.querySelectorAll('.starProducto');

    productStars.forEach((star, index) => {
        star.addEventListener('click', () => {
            // Encuentra el contenedor del modal padre de la estrella clicada
            const modal = star.closest('.modal');
            
            // Selecciona el input dentro de este modal específico
            const ratingInput = modal.querySelector('input[name="calificacion"]');
            
            // Itera a través de todas las estrellas
            productStars.forEach((s, i) => {
                if (s.children[0]) {
                    if (i <= index) {
                        s.children[0].classList.add('text-yellow-500');
                        s.children[0].classList.remove('text-gray-300');
                    } else {
                        s.children[0].classList.remove('text-yellow-500');
                        s.children[0].classList.add('text-gray-300');
                    }
                }
            });

            // Guarda el valor de la calificación en el input oculto
            if (ratingInput) {
                ratingInput.value = star.dataset.value;
            } else {
                console.error("No se encontró el input 'calificacion' en el modal.");
            }
        });
    });

    document.querySelectorAll('form').forEach(form => {
        // si el id del form es search-form se activa el evento submit
        if (form.id === 'search-form') {
            return;
        }
        form.addEventListener('submit', event => {
            event.preventDefault();

            const data = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    console.error(data);
                }
            });
        });
    });

});

function toggleModal(id) {
    document.getElementById('modal' + id).classList.toggle('hidden');
}
