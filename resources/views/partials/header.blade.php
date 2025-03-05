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
    <nav class="bg-[#5A8E95] border-gray-200">
        <div class="max-w-100 h-20 flex justify-between items-center mx-6 py-0">
            <!-- Logo + Texte -->
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
            <a href="{{ route('home') }}">
                <button>
                    <img src="{{ asset('storage/images/Logo_white_mode.png') }}" alt="Logo" class="w-18 h-16">
                </button>
            </a>
            <span class="self-center text-2xl font-semibold whitespace-nowrap">Cesi ton stage</span>
            </div>

            <!-- Menu central -->
            <div class="flex-grow flex justify-center hidden md:flex">
                <ul class="flex flex-col font-medium text-2xl p-4 md:p-0 mt-4 border md:space-x-20 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0  ">
                    <li><a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Accueil</a></li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Offres</a></li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Entreprises</a></li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Avis</a></li>
                </ul>
            </div>

            <!-- User Account à droite -->
            <div class="flex items-center space-x-3">
                @auth
                <button type="button" class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <img class="rounded-full" src="storage/images/icon_login.jpeg" alt="user photo" width="50" height="50">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm overflow-hidden" id="user-dropdown">
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li><a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a></li>
                        <li><a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a></li>
                        <hr class="border-gray-200">

                        @role('Admin')
                        <li><a href="{{ route('pilots_list') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pilotes</a></li>
                        <li><a href="{{ route('students_list') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Étudiants</a></li>
                        @endrole

                        @role('Pilote')
                        <li><a href="{{ route('students_list') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Étudiant</a></li>
                        @endrole

                        <hr class="border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                        </form>
                    </ul>
                </div>
                @else
                <button type="button" class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <img class="rounded-full" src="storage/images/icon_login.jpeg" alt="user photo" width="50" height="50">
                </button>
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm overflow-hidden" id="user-dropdown">
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li><a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign in</a></li>
                    </ul>
                </div>
                @endauth
                <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 " aria-controls="navbar-user" aria-expanded="false">
                    <!-- data-collapse-toggle="navbar-user": Cet attribut de données personnalisé indique que ce bouton doit basculer (ouvrir/fermer) un élément avec l'identifiant "navbar-user". -->
                    <!-- aria-controls="navbar-user": Cet attribut ARIA (Accessible Rich Internet Applications) indique que le bouton contrôle l'élément avec l'identifiant "navbar-user". -->
                    <!-- aria-expanded="false": Cet attribut ARIA (Accessible Rich Internet Applications) indique l'état étendu de l'élément associé. Valeur "false" signifie que l'élément est actuellement replié. -->
                    <img src="{{ asset('storage/images/burger_menu.svg') }}" alt="Menu burger" width="35" height="35">
                </button>   
            </div>

        </div>
    </nav>
</body>

</html>
