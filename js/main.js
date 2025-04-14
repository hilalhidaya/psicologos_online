
document.addEventListener("DOMContentLoaded", () => {
    const secciones = document.querySelectorAll("section");
    secciones.forEach((seccion, index) => {
      setTimeout(() => {
        seccion.classList.add("animar-aparicion");
      }, index * 200);
    });
  });
  