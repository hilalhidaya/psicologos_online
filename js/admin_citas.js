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

document.addEventListener('DOMContentLoaded', function () {
    const fechaInput = document.querySelector('input[name="fecha"]');
    const horaInput = document.querySelector('input[name="hora"]');

    if (!fechaInput || !horaInput) return;

    // Establecer fecha mínima (hoy) y máxima (hoy + 1 mes)
    const now = new Date();
    const today = now.toISOString().split('T')[0];
    const maxDate = new Date();
    maxDate.setMonth(maxDate.getMonth() + 1);
    const maxDateStr = maxDate.toISOString().split('T')[0];

    fechaInput.min = today;
    fechaInput.max = maxDateStr;

    function validarFechaHora() {
        const fechaSeleccionada = new Date(fechaInput.value);
        const horaSeleccionada = horaInput.value;

        if (fechaSeleccionada.getDay() === 0 || fechaSeleccionada.getDay() === 6) {
            alert('No se pueden agendar citas los fines de semana.');
            fechaInput.value = '';
            return false;
        }

        const horaParts = horaSeleccionada.split(':');
        const hora = parseInt(horaParts[0]);

        if (hora < 10 || hora >= 19) {
            alert('El horario permitido es de 10:00 a 19:00.');
            horaInput.value = '';
            return false;
        }

        return true;
    }

    fechaInput.addEventListener('change', validarFechaHora);
    horaInput.addEventListener('change', validarFechaHora);
});