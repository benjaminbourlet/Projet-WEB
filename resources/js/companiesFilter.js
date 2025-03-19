document.addEventListener("DOMContentLoaded", function() {
    const sectorSelect = document.getElementById("sector-select");
    const selectedSectorsContainer = document.getElementById("selected-sectors");
    const sectorInput = document.getElementById("sector-input"); // Récupère le champ caché

    // Liste des secteurs sélectionnés (Set pour éviter les doublons)
    let selectedSectors = new Set(getUrlParams());

    // Met à jour l'affichage des secteurs sélectionnés
    function updateSelectedSectors() {
        selectedSectorsContainer.innerHTML = "";

        selectedSectors.forEach(id => {
            let option = sectorSelect.querySelector(`option[value="${id}"]`);
            if (option) {
                let tag = document.createElement("div");
                tag.className = "flex items-center bg-blue-200 px-3 py-1 rounded-md";
                tag.innerHTML = `
            <span>${option.text}</span>
            <button type="button" class="ml-2 text-red-600 font-bold remove-sector" data-id="${id}">×</button>
        `;
                selectedSectorsContainer.appendChild(tag);
            }
        });

        // Mise à jour de l'URL
        updateUrlParams();

        // Mise à jour du champ caché avec les secteurs sélectionnés
        sectorInput.value = Array.from(selectedSectors).join(",");
    }

    // Fonction pour récupérer les valeurs de l'URL
    function getUrlParams() {
        const params = new URLSearchParams(window.location.search);
        let sectors = params.get("sector");
        return sectors ? sectors.split(",") : [];
    }

    // Fonction pour mettre à jour l'URL
    function updateUrlParams() {
        const params = new URLSearchParams(window.location.search);
        if (selectedSectors.size > 0) {
            params.set("sector", Array.from(selectedSectors).join(","));
        } else {
            params.delete("sector");
        }
        window.history.replaceState({}, "", "?" + params.toString());
    }

    // Sélection d'un secteur
    sectorSelect.addEventListener("change", function() {
        let selectedValue = sectorSelect.value;
        if (selectedValue && !selectedSectors.has(selectedValue)) {
            selectedSectors.add(selectedValue);
            updateSelectedSectors();
        }
        sectorSelect.value = ""; // Reset du select
    });

    // Suppression d'un secteur
    selectedSectorsContainer.addEventListener("click", function(event) {
        if (event.target.classList.contains("remove-sector")) {
            let sectorId = event.target.dataset.id;
            selectedSectors.delete(sectorId);
            updateSelectedSectors();
        }
    });

    // Initialisation au chargement de la page
    updateSelectedSectors();

    // Soumettre le formulaire avec les secteurs sélectionnés dans l'input caché
    const form = document.querySelector("form"); // Récupère le formulaire
    form.addEventListener("submit", function(e) {
        // On met à jour l'input caché avant la soumission
        sectorInput.value = Array.from(selectedSectors).join(",");
    });
});