
document.addEventListener("DOMContentLoaded", () => {
    const secciones = document.querySelectorAll("section");
    secciones.forEach((seccion, index) => {
      setTimeout(() => {
        seccion.classList.add("animar-aparicion");
      }, index * 200);
    });
  });
  

 
  function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('activo');
  }

