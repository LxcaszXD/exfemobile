var swiper = new Swiper(".mySwiper", {

  pagination: {
    el: ".swiper-pagination",
    dynamicBullets: true,
  },
});

const links = document.querySelectorAll("nav a");

links.forEach(link => {
  link.addEventListener("click", function () {
    // Remove 'active' de todos os links
    links.forEach(l => l.classList.remove("active"));
    
    // Adiciona 'active' apenas ao link clicado
    this.classList.add("active");
  });
});



