const editButton = document.getElementById("btn-edit");
let editable = false;

// Botón editar perfil
if (editButton) {
    editButton.addEventListener("click", (e) => {
        e.preventDefault();
        if (!editable) {
            editButton.innerHTML = `
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fa-solid fa-x text-[17px] text-gray-300 duration-300 group-hover:text-gray-500"></i>
            </span>
            Cancelar
        `;

            document.getElementById("btn-submit").classList.toggle("hidden");
            document
                .querySelector('input[type=file]')
                .classList.toggle("hidden");
            document.querySelectorAll("[disabled]").forEach((input) => {
                input.disabled = editable;
            });
            editable = !editable;
        } else {
            Swal.fire({
                icon: "warning",
                title: "¿Estás seguro?",
                text: "Perderás todos los cambios hechos.",
                // Confirm Button
                confirmButtonText: "Sí, continuar",
                confirmButtonColor: "#3085d6",
                // Cancel button
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        }
    });
}
