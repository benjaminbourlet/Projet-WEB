document.addEventListener("DOMContentLoaded", function () {
    var canvas = document.getElementById('applicationsChart');
    if (!canvas) {
        console.error("Le canvas n'existe pas !");
        return;
    }

    var ctx = canvas.getContext('2d');

    // Convertir les valeurs en nombres
    var accepted = parseInt(canvas.dataset.accepted) || 0;
    var rejected = parseInt(canvas.dataset.rejected) || 0;
    var pending = parseInt(canvas.dataset.pending) || 0;
    var traitement = parseInt(canvas.dataset.traitement) || 0;
    var interview = parseInt(canvas.dataset.interview) || 0;

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Acceptées', 'Refusées', 'En attente', 'En cours de traitement', 'Entretien programmé'],
            datasets: [{
                data: [accepted, rejected, pending, traitement, interview],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#0371b0', '#e410e7'],
                borderColor: ['#fff', '#fff', '#fff', '#fff', '#fff'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
