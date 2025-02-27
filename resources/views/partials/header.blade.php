<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Header page</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.3/flowbite.min.js"></script>

</head>

<body>


    <nav class="bg-[#5A8E95] border-gray-200 ">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="images/Logo_white_mode.png" class="h-8" alt="Cesi ton stage Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap ">Cesi ton stage</span>
                <!-- on utilise span car nous cherchons à stylisé une texte un texte et non pas à l'afficher en tant que block -->
                <!-- whitespace-nowrap : Cet utilitaire de classe Tailwind CSS empêche le texte de se retourner à la ligne. -->


            </a>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="flex text-sm rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 " id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <!-- aria-expanded="false" : Cet attribut ARIA (Accessible Rich Internet Applications) indique l'état étendu du menu associé. Valeur "false" signifie que le menu est actuellement replié. -->
                    <!-- data-dropdown-toggle="user-dropdown": Cet attribut de données personnalisé indique que ce bouton doit basculer (ouvrir/fermer) un menu déroulant avec l'identifiant "user-dropdown". -->
                    <!-- data-dropdown-placement="bottom": Cet attribut de données personnalisé indique que le menu déroulant doit être placé en bas du bouton. -->
                    <img class="w-8 h-8 rounded-full" src="images/icon_login.svg" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm :bg-gray-700" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 ">Username</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ">Dashboard</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ">Settings</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ">Earnings</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ">Sign in</a>
                        </li>
                    </ul>
                </div>
                <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 " aria-controls="navbar-user" aria-expanded="false">
                    <!-- data-collapse-toggle="navbar-user": Cet attribut de données personnalisé indique que ce bouton doit basculer (ouvrir/fermer) un élément avec l'identifiant "navbar-user". -->
                    <!-- aria-controls="navbar-user": Cet attribut ARIA (Accessible Rich Internet Applications) indique que le bouton contrôle l'élément avec l'identifiant "navbar-user". -->
                    <!-- aria-expanded="false": Cet attribut ARIA (Accessible Rich Internet Applications) indique l'état étendu de l'élément associé. Valeur "false" signifie que l'élément est actuellement replié. -->
                    <img src="images/burger_menu.svg" alt="Menu burger" width="35" height="35">
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0  ">
                    <li>
                        <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 ">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 ">About</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 ">Services</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 ">Pricing</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 ">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</body>

</html>