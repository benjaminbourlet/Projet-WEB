<header class="bg-[#5A8E95] flex flex-wrap items-center justify-between px-6 py-2">
    <div class="flex items-center space-x-4">
        <a href="{{ route('home') }}">
            <button>
                <img src="{{ asset('images/Logo_white_mode.png') }}" alt="Logo" class="w-18 h-20" href="{{ route('home') }}">
            </button>
        </a>
        <nav class="hidden md:flex space-x-16 text-white text-2xl">
            <a href="{{ route('home') }}" class="hover:underline">Accueil</a>
            <a href="#" class="hover:underline">Offres</a>
            <a href="#" class="hover:underline">Entreprise</a>
            <a href="#" class="hover:underline">Avis</a>
        </nav>
    </div>

    @auth
        <!-- Bouton Mon Compte avec Menu Déroulant -->
        <div class="relative">
            <button id="accountBtn" class="bg-[#387077] px-10 py-2 border border-white text-white rounded-full hover:bg-[#43868c] text-xl flex items-center">
                Mon compte
                <svg class="w-5 h-5 ml-2" fill="white" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Menu Déroulant -->
            <div id="accountMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 text-gray-700">
                <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-200">Profil</a>
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-200">Tableau de bord</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-200">Déconnexion</button>
                </form>
            </div>
        </div>
    @else
        <!-- Bouton Connexion -->
        <a href="{{ route('login') }}" class="bg-[#387077] px-10 py-2 border border-white text-white rounded-full hover:bg-[#43868c] text-xl">Connexion</a>
    @endauth
</header>