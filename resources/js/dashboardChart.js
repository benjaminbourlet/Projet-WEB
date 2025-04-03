//Dashboard profil

document.addEventListener("DOMContentLoaded", function () {
    // Applications Chart
    const applicationsCanvas = document.getElementById("applicationsChart");
    if (applicationsCanvas) {
        const ctx = applicationsCanvas.getContext("2d");
        const accepted = parseInt(applicationsCanvas.dataset.accepted) || 0;
        const rejected = parseInt(applicationsCanvas.dataset.rejected) || 0;
        const pending = parseInt(applicationsCanvas.dataset.pending) || 0;
        const traitement = parseInt(applicationsCanvas.dataset.traitement) || 0;
        const interview = parseInt(applicationsCanvas.dataset.interview) || 0;

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
                        labels: {
                            color: '#fff',
                        },
                        position: 'bottom'
                    }
                }
            }
        });
    }

    //Dashboard offers
    // Skills Chart
    const skillsCanvas = document.getElementById("skillsChart");
    if (skillsCanvas) {
        const ctx1 = skillsCanvas.getContext("2d");
        const labels = JSON.parse(skillsCanvas.dataset.labels || "[]");
        const counts = JSON.parse(skillsCanvas.dataset.counts || "[]");

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nombre d\'offres',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Duration Chart
    const durationCanvas = document.getElementById("durationChart");
    if (durationCanvas) {
        const ctx2 = durationCanvas.getContext("2d");
        const labels = JSON.parse(durationCanvas.dataset.labels || "[]");
        const counts = JSON.parse(durationCanvas.dataset.counts || "[]");

        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
                }]
            },
            options: {
                responsive: true
            }
        });
    }
});

//message de succès

setTimeout(() => {
    let successMessage = document.getElementById('success-message');
    if (successMessage) {
        successMessage.style.transition = "opacity 1s";
        successMessage.style.opacity = "0";
        setTimeout(() => successMessage.remove(), 1000);
    }
}, 1500);