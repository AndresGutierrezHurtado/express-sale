document.getElementById('mail-form-contact').addEventListener('submit', (e) => {
    e.preventDefault();

    let mail = new FormData();
    mail.append('subject', document.getElementById('subject-mail').value);
    mail.append('message', document.getElementById('message-mail').value);
    mail.append('emailFrom', document.getElementById('email-mail').value);
    mail.append('fullNameFrom', document.getElementById('full-name-mail').value);
    const data = {
        id: document.getElementById('session_id').value,
        username: document.getElementById('username_session').value,
        email: document.getElementById('email_session').value,
    }
    mail.append('data', JSON.stringify(data));

    fetch('/mail/footerForm', {
        method : 'POST',
        body : mail,
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.reload();
        }
    });
})