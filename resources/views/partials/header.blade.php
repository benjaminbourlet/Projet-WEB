@extends('layouts.app')

<body>
    <nav class="bg-[#5A8E95] border-gray-200">
        <div class="max-w-100 h-20 flex justify-between items-center mx-6 py-0">
            <!-- Logo + Texte -->
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
            <a href="{{ route('home') }}">
                <button>
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-18 h-16">
                </button>
            </a>
            <span class="self-center text-2xl font-semibold whitespace-nowrap">Stage_Finder</span>
            </div>

            <!-- Menu central -->
            <div class="items-center justify-between hidden md:flex md:w-auto " id="navbar-user">
                <ul class="flex flex-col font-medium text-2xl p-4 md:p-0 mt-4 border md:space-x-20 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0  ">
                <li><a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Accueil</a></li>
                    <li><a href="{{ route('offer_list') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Offres</a></li>
                    <li><a href="{{ route('company_list') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Entreprises</a></li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Avis</a></li>
                </ul>
            </div>

            <div id="popup-modal" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                    <!-- Contenu du modal -->
                    <div class="relative bg-[#5A8E95] rounded-lg shadow">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-toggle="popup-modal">
                            <img src="{{ asset('storage/images/icon_cross.svg') }}" alt="close_menu" width="20"
                                height="20">
                        </button>
                        <div class="py-6 px-6 lg:px-8">
                            <div class="items-center justify-between bg-white md:flex md:w-auto md:order-1"
                                id="navbar-user">
                                <ul
                                    class="flex flex-col font-medium text-2xl p-4 md:p-0 mt-4 border md:space-x-20 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                                    <li><a href="#"
                                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Accueil</a>
                                    </li>
                                    <li><a href="{{ route('offer_list') }}"
                                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Offres</a>
                                    </li>
                                    <li><a href="{{ route('company_list') }}"
                                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Entreprises</a>
                                    </li>
                                    <li><a href="#"
                                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white md:p-0">Avis</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- User Account à droite -->
            <div class="flex items-center space-x-3">
                @auth
                    <!-- Affiche la photo de profil si l'utilisateur est connecté -->
                    <button type="button" class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">
                        <img class="rounded-full" src="{{ asset('storage/' . auth()->user()->pp_path) }}" alt="user photo"
                            width="50" height="50">
                    </button>
                @else
                <!-- Affiche l'icône de connexion si l'utilisateur n'est pas connecté -->
                <button type="button" class="flex text-sm rounded-full focus:ring-4 focus:ring-black" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <img class="rounded-full" src="storage/images/icon_login.jpeg" alt="user photo" width="50" height="50">
                </button>
                @endauth
                <!-- Dropdown menu -->
                @auth
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm overflow-hidden"
                        id="user-dropdown">
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="{{ route('dashboard', ['id' => Auth::user()->id]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Dashboard
                                </a>
                            </li>
                            <li><a href="{{ route('profile', ['id' => Auth::user()->id]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a></li>
                            <hr class="border-gray-200">

                            @role('Admin')
                            <li><a href="{{ route('pilots_list') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pilotes</a></li>
                            <li><a href="{{ route('students_list') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Étudiants</a></li>
                            @endrole

                            @role('Pilote')
                            <li><a href="{{ route('students_list') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Étudiant</a></li>
                            @endrole

                            @role('Admin|Etudiant')
                            <li><a href="{{ route('applications_list', ['user_id' => Auth::user()->id]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mes candidatures</a>
                            </li>
                            <li><a href="{{ route('wishlists_list', ['user_id' => Auth::user()->id]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ma wishlist</a>
                            </li>
                            @endrole

                            <hr class="border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                            </form>
                        </ul>
                    </div>
                @else
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm overflow-hidden"
                        id="user-dropdown">
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li><a href="{{ route('login') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign in</a></li>
                        </ul>
                    </div>
                @endauth


                <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="btn md:hidden">
                    <img src="{{ asset('storage/images/burger_menu.svg') }}" alt="Menu burger" width="35" height="35">
                </button>

            </div>

        </div>
    </nav>
</body>

</html>