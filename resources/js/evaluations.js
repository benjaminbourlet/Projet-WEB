document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    const gradeInput = document.getElementById('grade');

    stars.forEach((star, index) => {
        star.addEventListener('click', function () {
            const value = parseInt(this.getAttribute('data-value'));

            gradeInput.value = value;

            // Mise à jour des couleurs des étoiles
            stars.forEach((s, i) => {
                s.classList.remove('text-yellow-300', 'text-gray-300');
                if (i < value) {
                    s.classList.add('text-yellow-300'); // Jaune pour les étoiles sélectionnées
                } else {
                    s.classList.add('text-gray-300'); // Gris pour les autres
                }
            });
        });
    });
});