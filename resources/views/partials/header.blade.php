<header class="bg-[#5A8E95] flex flex-wrap items-center justify-between px-6 py-2">
    <div class="flex items-center space-x-4">
        <a href="{{ route('home') }}">
            <button>
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-18 h-20">
            </button>
        </a>
        <nav class="hidden md:flex space-x-16 text-white text-2xl">
            <a href="{{ route('home') }}" class="hover:underline">Accueil</a>
            <a href="#" class="hover:underline">Offres</a>
            <a href="{{ route('company_list') }}" class="hover:underline">Entreprise</a>
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

                @role('Admin')
                    <hr class="border-gray-200">
                    <a href="{{ route('pilots_list') }}" class="block px-4 py-2 hover:bg-gray-200">Pilotes</a>
                    <a href="{{ route('students_list') }}" class="block px-4 py-2 hover:bg-gray-200">Étudiants</a>
                @endrole

                    @role('Pilote')
                    <hr class="border-gray-200">
                    <a href="{{ route('students_list') }}" class="block px-4 py-2 hover:bg-gray-200">Étudiants</a>
                @endrole
                
                <hr class="border-gray-200">
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

<!-- Script JavaScript pour le menu déroulant -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const accountBtn = document.getElementById("accountBtn");
        const accountMenu = document.getElementById("accountMenu");

        accountBtn.addEventListener("click", function () {
            accountMenu.classList.toggle("hidden");
        });

        // Fermer le menu si on clique ailleurs
        document.addEventListener("click", function (event) {
            if (!accountBtn.contains(event.target) && !accountMenu.contains(event.target)) {
                accountMenu.classList.add("hidden");
            }
        });
    });
</script>