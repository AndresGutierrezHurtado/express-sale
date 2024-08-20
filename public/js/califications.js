document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.fetch-form' ).forEach(form => {
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
