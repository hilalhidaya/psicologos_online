function toggleMenu(btn) {
    const menu = btn.nextElementSibling;
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    document.querySelectorAll('.menu-acciones').forEach(m => {
      if (m !== menu) m.style.display = 'none';
    });
  }
  document.addEventListener('click', function (e) {
    if (!e.target.matches('.btn-acciones')) {
      document.querySelectorAll('.menu-acciones').forEach(m => m.style.display = 'none');
    }
  });

  function mostrarEditarCita(id, fecha, hora, motivo) {
    document.getElementById('formEditarCita').style.display = 'block';
    document.getElementById('editarIdCita').value = id;
    document.getElementById('editarFecha').value = fecha;
    document.getElementById('editarHora').value = hora;
    document.getElementById('editarMotivo').value = motivo;
  }

  document.getElementById('btn-editar').addEventListener('click', function () {
    const inputs = document.querySelectorAll('#formulario-perfil input:not([type=email]), #formulario-perfil select');
    inputs.forEach(input => input.disabled = false);
    document.getElementById('btn-guardar').style.display = 'inline-block';
    this.style.display = 'none';
});