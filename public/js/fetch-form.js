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
                alert(data.message);
                if (redirect !== undefined) {
                    window.location.href = redirect;
                } else {
                    window.location.reload();
                }
            } else {
                alert("Error: " + data.error);
            }
        });
}

function login(event = undefined) {
    event?.preventDefault();

    if (
        confirm(
            "Tienes que iniciar sesión para calificar un producto. ¿Deseas iniciar sesión?"
        )
    ) {
        window.location.href = "/page/login/";
    }
}
