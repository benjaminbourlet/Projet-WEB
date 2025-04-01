document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".carousel-item");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    let currentIndex = 0;
    const visibleSlides = 3;

    function updateCarousel() {
        slides.forEach((slide, index) => {
            if (index >= currentIndex && index < currentIndex + visibleSlides) {
                slide.classList.remove("hidden", "opacity-0");
                slide.classList.add("flex", "opacity-100");
            } else {
                slide.classList.add("hidden", "opacity-0");
                slide.classList.remove("flex", "opacity-100");
            }
        });
    }

    prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = slides.length - visibleSlides;
        }
        updateCarousel();
    });

    nextBtn.addEventListener("click", () => {
        if (currentIndex < slides.length - visibleSlides) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    });

    updateCarousel(); // Initialisation
});
