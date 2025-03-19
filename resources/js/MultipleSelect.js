document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Le DOM est chargé !");
    function setupTagSelection(selectId, displayId, inputName) {
        const select = document.getElementById(selectId);
        const displayDiv = document.getElementById(displayId);

        if (!select || !displayDiv) return;

        select.addEventListener("change", function () {
            const selectedValue = select.value;
            const selectedText = select.options[select.selectedIndex].text;

            if (!selectedValue || document.querySelector(
                `input[name="${inputName}"][value="${selectedValue}"]`)) {
                return; // Évite d'ajouter des doublons ou une valeur vide
            }

            // Crée l'élément tag
            const tag = document.createElement("span");
            tag.className =
                "bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded flex items-center";
            tag.innerHTML = `${selectedText} 
                <button type="button" class="ml-2 text-red-500 hover:text-red-700" onclick="this.parentElement.remove(); this.parentElement.querySelector('input').remove();">
                    &times;
                </button>`;


            // Ajoute un input hidden pour l'envoyer au serveur
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = inputName;
            hiddenInput.value = selectedValue;

            tag.appendChild(hiddenInput);
            displayDiv.appendChild(tag);

            // Réinitialise le select
            select.value = "";
        });
    }
    setupTagSelection("sectors", "selected-sectors", "sectors[]");
    setupTagSelection("departments", "selected-departments", "departments[]");
    setupTagSelection("skills", "selected-skills", "skills[]");
    setupTagSelection("classesPilots", "selected-classesPilots", "classesPilots[]");
    
});