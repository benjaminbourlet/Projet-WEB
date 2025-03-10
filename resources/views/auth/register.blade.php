<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script>
        // attente du chargement du DOM (Document Object Model)
        document.addEventListener("DOMContentLoaded", function () {
            // prends tous les éléments qui ont un attribut data-dropdown-toggle
            var elements = document.querySelectorAll("[data-dropdown-toggle]");
            // boucle sur les tous les elements data-dropdown-toggle
            elements.forEach(function (element) {
                //recupération de l'élément qui a l'id correspondant à la valeur de l'attribut data-dropdown-toggle
                var dropdown = document.getElementById(element.dataset.dropdownToggle);
                // ajout de l'evenement click sur l'élément
                element.addEventListener("click", function (e) {
                    // annule l'action par défaut du click (convention qu'il faut mettre)
                    e.preventDefault();
                    dropdown.classList.toggle("hidden");
                    dropdown.classList.toggle("block");
                });
            });
        });
    </script>
</head>
<body>
    @include('partials.header')
    <div class="bg-gray-500 rounded-lg m-10">
        <div class="grid md:grid-cols-2 grid-cols-1">
            <!-- lg : Coté gauche // sm : en haut -->
            <div class="bg-blue-500 p-4 rounded-lg">

                <!-- Début du formulaire d'inscription -->
                <!-- Nom (student) -->
                <label for="name" class="block text-black font-medium md:text-right">Nom de l'étudiant</label>
                <!-- Nom (pilote) -->
                {{-- <label for="name" class="block text-black font-medium mt-4">Nom du pilote</label> --}}

                <input type="text" name="name" id="name" class="mt-2 p-2 bg-gray-200 rounded-full w-full">
                
                <!-- Prénom (student) -->
                <label for="firstname" class="block text-black font-medium mt-4 md:text-right">Prénom de l'étudiant</label>
                <!-- Prénom (pilote) -->
                {{-- <label for="firstname" class="block text-black font-medium mt-4">Prénom du pilote</label> --}}

                <input type="text" name="firstname" id="firstname" class="mt-2 p-2 bg-gray-200 rounded-full w-full">

                <!-- Etablissement -->
                <label for="etablissement" class="block text-black font-medium mt-4 md:text-right">Etablissement</label>
                <input type="text" name="etablissement" id="etablissement" class="mt-2 p-2 bg-gray-200 rounded-full w-full">

                <!-- Promotion (student) -->
                <label for="promotion" class="block text-black font-medium mt-4 md:text-right">Promotion</label> 
                <input type="text" name="promotion" id="promotion" class="mt-2 p-2 bg-gray-200 rounded-full w-full">
                
                <!-- Promotion (pilote) -->
                {{--
                <button id="dropdown_promo_button" data-dropdown-toggle="dropdown_checkbox" class="text-black mt-10 p-2 bg-gray-200  hover:bg-gray-300  shadow-md border border-black rounded-full w-full" type="button">
                    Ses promotions
                </button>
                    
                <!-- Dropdown menu -->
                <div id="dropdown_checkbox" class="z-10 my-2 hidden w-full bg-white divide-y divide-gray-100 rounded-lg shadow-sm ">
                    <ul class="p-3 space-y-3 text-sm text-gray-700 " aria-labelledby="dropdown_promo_button">
                    <li>
                        <div class="flex items-center">
                        <input id="checkbox-item-1" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                        <label for="checkbox-item-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">CPI A1</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <input checked id="checkbox-item-2" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                            <label for="checkbox-item-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">CPI A2 Informatique</label>
                        </div>
                    </li>
    
                </div>
                --}}
    
                

            </div>

            <!-- lg : Coté droite // sm : en bas -->
            <div class="bg-gray-500 p-4 rounded-lg">
                <!-- Email -->
                <label for="email" class="block text-black font-medium">Email</label>
                <input type="email" name="email" id="email" class="mt-2 p-2 bg-gray-200 rounded-full w-full">

                <!-- Mot de passe -->
                <label for="password" class="block text-black font-medium mt-4">Mot de passe</label>
                <input type="password" name="password" id="password" class="mt-2 p-2 bg-gray-200 rounded-full w-full">

                <!-- Confirmation du mot de passe -->
                <label for="password_confirmation" class="block text-black font-medium mt-4">Confirmation du mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-2 p-2 bg-gray-200 rounded-full w-full">

                <!-- Bouton d'inscription (student) -->
                <button class="bg-blue-500 text-white mt-12 p-2 rounded-full w-full">Ajouter l'étudiant</button>

            </div>
        </div>

    </div>

    
    @include('partials.footer')
    
</body>
</html>
