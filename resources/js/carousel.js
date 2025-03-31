document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector("#carousel .flex");
    const slides = document.querySelectorAll(".carousel-item");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    let currentIndex = 0;
    const visibleSlides = 3; // Nombre d'entreprises visibles

    function updateCarousel() {
        slides.forEach((slide, index) => {
            if (index >= currentIndex && index < currentIndex + visibleSlides) {
                slide.classList.remove("hidden"); // Afficher les 3 slides
                slide.classList.add("flex"); // Garder l'affichage en flex
            } else {
                slide.classList.add("hidden"); // Cacher les autres
                slide.classList.remove("flex");
            }
        });
    }

    prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = slides.length - visibleSlides; // Boucle vers la fin
        }
        updateCarousel();
    });

    nextBtn.addEventListener("click", () => {
        if (currentIndex < slides.length - visibleSlides) {
            currentIndex++;
        } else {
            currentIndex = 0; // Retour au début
        }
        updateCarousel();
    });

    updateCarousel(); // Initialisation
});