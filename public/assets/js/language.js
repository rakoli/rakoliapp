// language.js

document.addEventListener('DOMContentLoaded', function () {
    const languageLinks = document.querySelectorAll('[data-kt-lang]');

    languageLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const lang = this.getAttribute('data-kt-lang');

            console.log(lang);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("/change-language", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ lang: lang }),
            }).then(function () {
                location.reload();
            });
        });
    });
});

function changeLanguage(lang) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("/change-language", {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken, // Make sure to replace this with your actual CSRF token
        },
        body: JSON.stringify({ lang: lang }),
    }).then(function () {
        location.reload();
    });
}
