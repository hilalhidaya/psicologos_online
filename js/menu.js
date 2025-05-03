document.addEventListener("DOMContentLoaded", function () {
    // Menú hamburguesa
    const toggle = document.getElementById("menu-toggle");
    const navLinks = document.querySelector(".nav-links");
  
    if (toggle && navLinks) {
      toggle.addEventListener("click", () => {
        navLinks.classList.toggle("show");
      });
    }
  
    // Submenú en móviles
    const submenuLink = document.querySelector(".submenu > a");
    submenuLink?.addEventListener("click", function (e) {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        this.parentElement.classList.toggle("submenu-open");
      }
    });
  
    // Sticky con scroll
    const navbar = document.querySelector(".navbar");
    window.addEventListener("scroll", () => {
      if (window.scrollY > 10) {
        navbar.classList.add("scrolling");
      } else {
        navbar.classList.remove("scrolling");
      }
    });
  });
  