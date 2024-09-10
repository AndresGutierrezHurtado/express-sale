const forms = document.querySelectorAll('.fetch-form');
const themeController = document.querySelector('.theme-controller');

forms.forEach(form => {
    form.addEventListener('submit', event => {
        event.preventDefault();

        const data = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: data
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    if (form.dataset.redirect !== undefined) {
                        window.location.href = form.dataset.redirect;
                    } else {
                        window.location.reload();
                    }
                } else {
                    alert('Error: ' + data.error);
                }
            });
    })
});