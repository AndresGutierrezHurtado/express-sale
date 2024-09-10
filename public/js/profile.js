const editButton = document.getElementById('btn-edit');
let editable = false;

// Botón editar perfil
editButton.addEventListener('click', (e) => {
    e.preventDefault();
    if (!editable) {

        editButton.innerHTML = `
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fa-solid fa-x text-[17px] text-gray-300 duration-300 group-hover:text-gray-500"></i>
            </span>
            Cancelar
        `;

        document.getElementById('btn-submit').classList.toggle('hidden');
        document.getElementById('usuario_imagen').classList.toggle('hidden');
        document.querySelectorAll('[disabled]').forEach(input => {
            input.disabled = editable;
        })
        editable = !editable

    } else {
        if (confirm('¿deseas cancelar?, perderás todos los cambios.')) {
            editButton.innerHTML = 'Editar';
            window.location.reload();
        }
    }
})
