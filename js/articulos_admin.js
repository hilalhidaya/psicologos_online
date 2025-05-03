function toggleCrearArticulo() {
    var form = document.getElementById('formCrearArticulo');
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
        setTimeout(function () {
            form.style.opacity = '1';
        }, 10);
    } else {
        form.style.opacity = '0';
        setTimeout(function () {
            form.style.display = 'none';
        }, 500);
    }
}

function toggleMenu(button) {
    const menu = button.nextElementSibling;
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';

    // Cierra otros menús abiertos
    document.querySelectorAll('.menu-acciones').forEach(function (otherMenu) {
        if (otherMenu !== menu) {
            otherMenu.style.display = 'none';
        }
    });
}

// Cierra el menú si haces click fuera
document.addEventListener('click', function (e) {
    if (!e.target.matches('.btn-acciones')) {
        document.querySelectorAll('.menu-acciones').forEach(function (menu) {
            menu.style.display = 'none';
        });
    }
});