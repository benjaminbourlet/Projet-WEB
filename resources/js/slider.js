document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du slider de salaire
    var salarySlider = document.getElementById('salary_slider');
    var minSalaryInput = document.getElementById('min_salaire');
    var maxSalaryInput = document.getElementById('max_salaire');
    var salaryMinValue = document.getElementById('salary_min_value');
    var salaryMaxValue = document.getElementById('salary_max_value');

    // Initialisation du slider de salaire
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

    // Mettre à jour les valeurs quand le slider de salaire est déplacé
    salarySlider.noUiSlider.on('update', function(values, handle) {
        if (handle === 0) {
            salaryMinValue.innerText = values[0]+ ' €';
            minSalaryInput.value = values[0];
        } else {
            salaryMaxValue.innerText = values[1]+ ' €';
            maxSalaryInput.value = values[1];
        }
    });

    // Initialisation du slider de durée
    var durationSlider = document.getElementById('duration_slider');
    var minDurationInput = document.getElementById('duration_min');
    var maxDurationInput = document.getElementById('duration_max');
    var durationMinValue = document.getElementById('duration_min_value');
    var durationMaxValue = document.getElementById('duration_max_value');

    // Initialisation du slider de durée
    noUiSlider.create(durationSlider, {
        start: [0, 180],
        connect: true,
        step: 10,
        range: {
            'min': [0],
            'max': [180]
        },
        step: 1,
        format: {
            to: function (value) {
                return Math.round(value);
            },
            from: function (value) {
                return value;
            }
        }
    });

    // Mettre à jour les valeurs quand le slider de durée est déplacé
    durationSlider.noUiSlider.on('update', function(values, handle) {
        if (handle === 0) {
            durationMinValue.innerText = values[0] + ' jours';
            minDurationInput.value = values[0];
        } else {
            durationMaxValue.innerText = values[1] + ' jours';
            maxDurationInput.value = values[1];
        }
    });

    // Ajout de l'événement submit pour s'assurer que les champs sont mis à jour avant l'envoi
    var form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        // Empêcher l'envoi immédiat du formulaire pour mettre à jour les valeurs
        event.preventDefault();
        
        // Assurer que les champs cachés sont mis à jour avec les valeurs actuelles des sliders
        minSalaryInput.value = salarySlider.noUiSlider.get()[0];
        maxSalaryInput.value = salarySlider.noUiSlider.get()[1];
        minDurationInput.value = durationSlider.noUiSlider.get()[0];
        maxDurationInput.value = durationSlider.noUiSlider.get()[1];

        // Enfin, soumettre le formulaire
        form.submit();
    });
});
