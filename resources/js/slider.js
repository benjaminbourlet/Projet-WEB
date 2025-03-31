document.addEventListener('DOMContentLoaded', function() {
    var salarySlider = document.getElementById('salary_slider');
    var minSalaryInput = document.getElementById('min_salaire');
    var maxSalaryInput = document.getElementById('max_salaire');
    var salaryMinValue = document.getElementById('salary_min_value');
    var salaryMaxValue = document.getElementById('salary_max_value');

    // Initialisation du slider
    noUiSlider.create(salarySlider, {
        start: [0, 10000],
        connect: true,
        range: {
            'min': [0],
            'max': [10000]
        },
        step: 100,
        format: {
            to: function (value) {
                return Math.round(value);
            },
            from: function (value) {
                return value;
            }
        }
    });

    // Mettre à jour les valeurs quand le slider est déplacé
    salarySlider.noUiSlider.on('update', function(values, handle) {
        if (handle === 0) {
            salaryMinValue.innerText = values[0];
            minSalaryInput.value = values[0];
        } else {
            salaryMaxValue.innerText = values[1];
            maxSalaryInput.value = values[1];
        }
    });

    // Ajout de l'événement submit pour s'assurer que les champs sont mis à jour avant l'envoi
    var form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        // Empêcher l'envoi immédiat du formulaire pour mettre à jour les valeurs
        event.preventDefault();
        
        // Assurer que les champs cachés sont mis à jour avec les valeurs actuelles du slider
        minSalaryInput.value = salarySlider.noUiSlider.get()[0];
        maxSalaryInput.value = salarySlider.noUiSlider.get()[1];

        // Enfin, soumettre le formulaire
        form.submit();
    });
});