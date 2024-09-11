const forms = document.querySelectorAll('.fetch-form');

forms.forEach(form => {
    form.addEventListener('submit', event => {
        event.preventDefault();

        const data = new FormData(form);
        
        useFetch(form.action, form.method, data, form.dataset.redirect || undefined);
    })
});


function useFetch(action, method, data, redirect = undefined) {
    fetch(action, {
        method: method,
        body: data
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                if (redirect !== undefined) {
                    window.location.href = redirect;
                } else {
                    window.location.reload();
                }
            } else {
                alert('Error: ' + data.error);
            }
        });
}