document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("menu-toggle");
  const navLinks = document.querySelector(".nav-links");
  const icon = toggle.querySelector("i");

  // Menú hamburguesa: abrir/cerrar + alternar ícono
  if (toggle && navLinks && icon) {
    toggle.addEventListener("click", () => {
      navLinks.classList.toggle("show");

      if (navLinks.classList.contains("show")) {
        icon.classList.remove("fa-bars");
        icon.classList.add("fa-xmark");
      } else {
        icon.classList.remove("fa-xmark");
        icon.classList.add("fa-bars");
      }
    });
  }

  // Submenú en móviles (Administración)
  const submenu = document.querySelector(".submenu");
  const submenuLink = submenu?.querySelector("a");

  if (submenu && submenuLink) {
    submenuLink.addEventListener("click", function (e) {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        submenu.classList.toggle("submenu-open");
      }
    });
  }

  // Cerrar menú al hacer clic en un enlace (solo móviles)
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth <= 768 && navLinks.classList.contains("show")) {
        navLinks.classList.remove("show");
        icon.classList.remove("fa-xmark");
        icon.classList.add("fa-bars");
      }
    });
  });
});
