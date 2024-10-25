document.addEventListener("DOMContentLoaded", function() {
    // Cek apakah ada elemen dengan ID error-message
    var errorMessageDiv = document.getElementById('error-message');

    if (errorMessageDiv) {
        // Ambil data dari atribut data-error
        var errorMessage = errorMessageDiv.getAttribute('data-error');

        if (errorMessage) {
            // Buat notifikasi menggunakan JavaScript (bisa diubah sesuai kebutuhan)
            var notification = document.createElement('div');
            notification.style.color = 'red';
            notification.style.margin = '10px 0';
            notification.innerText = errorMessage;

            // Sisipkan notifikasi di bagian atas form
            var container = document.querySelector('.container');
            container.insertBefore(notification, container.firstChild);
        }
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var hamburger = document.querySelector('.hamburger');
    var navbar = document.querySelector('nav');

    // Toggle the navbar when hamburger is clicked
    hamburger.addEventListener('click', function() {
        hamburger.classList.toggle('active');
        navbar.classList.toggle('show');
    });
});

