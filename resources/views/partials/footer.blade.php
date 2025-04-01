@extends('layouts.app')

<body>
    <footer>
        <div class="bg-[#5A8E95] w-full flex flex-wrap items-center justify-between px-6">
            <div class="w-full lg:w-auto flex flex-row lg:flex-col items-center justify-center lg:justify-start">
                <!-- Dropdown button pour la langue -->
                <div class="mx-6 py-4">
                    <button id="dropdown_country_button" data-dropdown-toggle="dropdown_country"
                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-xl px-7 py-3 text-center inline-flex items-center "
                        type="button">Langue
                        <!-- focus ring pour mettre en evidence le bouton -->
                        <!-- Icone fleche -->
                        <img src="{{ asset('storage/images/dropdown_arrow.svg') }}" alt="fleche de menu"
                            class="w-7 h-7 pt-1">
                    </button>

                    <!-- Dropdown menu langue-->
                    <div id="dropdown_country"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                        <!-- divide y pour diviser les liens -->
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown_country_button">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Francais</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Anglais</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Espagnol</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Italien</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Dropdown button pour la devise -->
                <div class="mx-6 py-4">
                    <button id="dropdown_monney_button" data-dropdown-toggle="dropdown_monney"
                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-xl px-7 py-3 text-center inline-flex items-center "
                        type="button">Monnaie
                        <!-- Icone fleche -->
                        <img src="{{ asset('storage/images/dropdown_arrow.svg') }}" alt="fleche de menu"
                            class="w-7 h-7 pt-1">
                    </button>

                    <!-- Dropdown menu devise-->
                    <div id="dropdown_monney"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown_monney_button">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Euros €</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Dollars $</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Livre £</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div>

                <!-- Sitemap links -->
                <div class="grid grid-cols-2 lg:py-8 md:grid-cols-3 pr-4 py-6">
                    <div>
                        <h2 class="mb-6 text-xl font-bold text-white">Nos clients</h2>
                        <ul class="text-white font-medium">
                            <li class="mb-4">
                                <a href="https://www.cesi.fr/" class=" hover:underline">CESI ECOLE D'INGENIEUR</a>
                            </li>
                            <li class="mb-4">
                                <a href="https://www.phenixtechnologie.fr/" class="hover:underline">PHÉNIX
                                    TECHNOLOGIE</a>
                            </li>
                            <li class="mb-4">
                                <a href="https://www.thalesgroup.com/fr" class="hover:underline">THALES</a>
                            </li>
                            <li class="mb-4">
                                <a href="https://www.orange.fr/portail" class="hover:underline">ORANGE CYBERSÉCURITÉ</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-xl font-bold text-white ">L'Entreprise</h2>
                        <ul class="text-white font-medium">
                            <li class="mb-4">
                                <a href="#" class="hover:underline">QUI SOMMES NOUS ?</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">ON RECRUTE !</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-xl font-bold text-white">Communauté</h2>
                        <ul class="text-white  font-medium">
                            <li class="mb-4">
                                <a href="#" class="hover:underline">CENTRE D'AIDE</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">TROUVER UN EXPERT</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">PLATEFORME DE DÉVELOPPEMENT</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">FORUM</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">PROFESSIONNEL</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- Social media links -->
            <div class="w-full flex flex-wrap items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="block text-sm text-white font-bold sm:text-center pl-4 pr-1">Nous suivre sur :</span>
                    <a href="https://github.com/benjaminbourlet/Projet-WEB.git"><img
                            src="{{ asset('storage/images/logo_github.svg') }}" width="30" height="30"></a>
                    <a href="https://x.com/MrBeast"><img src="{{ asset('storage/images/logo_twitter.svg') }}" width="30"
                            height="30"></a>
                    <a href="https://www.instagram.com/benjamiin_brl/"><img
                            src="{{ asset('storage/images/logo_instagram.svg') }}" width="30" height="30"></a>
                    <a href="https://www.linkedin.com/in/benjamin-bourlet-422b4032a/"><img
                            src="{{ asset('storage/images/logo_linkedin.svg') }}" width="30" height="30"></a>
                </div>
                <a href="{{ route('mentions-legales') }}"
                    class="block text-sm text-white sm:text-center p-4 rounded-lg transition duration-300">
                    Mentions Légales - Société Stage Finder ™ . All Rights Reserved.
                </a>
    </footer>

</body>

</html>