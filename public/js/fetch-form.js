const forms = document.querySelectorAll(".fetch-form");

forms.forEach((form) => {
    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const data = new FormData(form);

        useFetch(
            form.action,
            form.method,
            data,
            form.dataset.redirect || undefined
        );
    });
});

function useFetch(action, method, data, redirect = undefined) {
    if (data instanceof FormData == false) {
        if (typeof data == "string") data = JSON.parse(data);

        tmpdata = new FormData();

        for (const key in data) {
            tmpdata.append(key, data[key]);
        }

        data = tmpdata;
    }

    fetch(action, {
        method: method,
        body: data,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                Swal.fire({
                    title: "Acción exitosa",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: "Continuar",
                }).then(() => {
                    if (redirect !== undefined) {
                        window.location.href = redirect;
                    } else {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Hubo un error",
                    text: data.error,
                    footer: 'Si quieres notificar el error ve al <a href="/page/home/#footer_form" class="text-violet-600 hover:underline font-medium" >formulario de contacto</a>',
                });
            }
        });
}

function confirmAlert(e, title = "") {
    e.preventDefault(); // Detener temporalmente el envío del formulario

    Swal.fire({
        icon: "warning",
        title: title || "¿Estás seguro?",
        text: "No podrás revertir esta acción.",
        // Confirm Button
        confirmButtonText: "Sí, continuar",
        confirmButtonColor: "#3085d6",
        // Cancel button
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
            // Se hace de esta manera porque si se hace con el .submit no funcionaría el addEventListener del fetch-form
            e.target
                .closest(".fetch-form")
                .dispatchEvent(new Event("submit", { cancelable: true }));
        }
    });
}

function login(event = undefined, title = "") {
    event?.preventDefault();

    Swal.fire({
        icon: "error",
        title: "Error",
        text: "Debes iniciar sesión para realizar esta acción",
        // Confirm Button
        confirmButtonText: "Sí, continuar",
        confirmButtonColor: "#3085d6",
        // Cancel button
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "/page/login";
        }
    });
}
