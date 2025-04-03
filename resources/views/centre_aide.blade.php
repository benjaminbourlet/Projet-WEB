@extends('layouts.app')

@section('title', 'Centre d\'Aide')

@section('content')
  <main class="min-h-screen bg-gray-100 py-10">
    <div class="container mx-auto px-4">
    <!-- Header Section -->
    <header class="text-center mb-10">
      <h1 class="text-5xl font-bold text-gray-800">Centre d'Aide</h1>
      <p class="mt-4 text-lg text-gray-600">
      Bienvenue dans notre centre d'aide. Trouvez ici des réponses à vos questions et découvrez nos guides pour
      optimiser l'utilisation de nos services.
      </p>
      <div class="mt-6">
      <input type="text" placeholder="Rechercher une question..."
        class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300">
        <!--focus:outline-none : supprimer le contour visible par défaut qui entoure un élément lorsqu'il est sélectionné -->
      </div>
    </header>

    <!-- Articles Populaires Section -->
    <section class="mb-12">
      <h2 class="text-3xl font-semibold text-gray-800 mb-4">Articles Populaires</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-2xl font-bold text-gray-700 mb-2">Comment créer un compte</h3>
        <p class="text-gray-600">
        Découvrez les étapes simples pour créer un compte et commencer à utiliser nos services en quelques minutes.
        </p>
        <a href="#" class="inline-block mt-4 text-[#5A8E95] hover:underline">Lire la suite</a>
        <!-- hover:underline : souligner le texte au survol de la souris -->
        <!--inline-block : permet de rendre le lien cliquable et de lui donner un espacement autour -->
      </div>
      <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-2xl font-bold text-gray-700 mb-2">Réinitialiser votre mot de passe</h3>
        <p class="text-gray-600">
        Suivez nos instructions pour réinitialiser votre mot de passe en toute sécurité si vous l\'avez oublié.
        </p>
        <a href="#" class="inline-block mt-4 text-[#5A8E95] hover:underline">Lire la suite</a>
      </div>
      <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-2xl font-bold text-gray-700 mb-2">Sécuriser votre compte</h3>
        <p class="text-gray-600">
        Apprenez comment protéger vos informations personnelles et renforcer la sécurité de votre compte.
        </p>
        <a href="#" class="inline-block mt-4 text-[#5A8E95] hover:underline">Lire la suite</a>
      </div>
      <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
        <h3 class="text-2xl font-bold text-gray-700 mb-2">Utiliser notre application mobile</h3>
        <p class="text-gray-600">
        Explorez les fonctionnalités de notre application mobile pour profiter pleinement de nos services en
        déplacement.
        </p>
        <a href="#" class="inline-block mt-4 text-[#5A8E95] hover:underline">Lire la suite</a>
      </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="mb-12">
      <h2 class="text-3xl font-semibold text-gray-800 mb-4">FAQ</h2>
      <div class="space-y-4">
      <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="text-xl font-bold text-gray-700">Q: Comment puis-je modifier mes informations personnelles ?</h3>
        <p class="mt-2 text-gray-600">R: Vous pouvez modifier vos informations personnelles en accédant à la section «
        Profil » de votre compte.</p>
      </div>
      <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="text-xl font-bold text-gray-700">Q: Quels sont les moyens de paiement acceptés ?</h3>
        <p class="mt-2 text-gray-600">R: Nous acceptons les paiements par carte bancaire, PayPal et d'autres moyens de
        paiement sécurisés.</p>
      </div>
      <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="text-xl font-bold text-gray-700">Q: Comment contacter le support technique ?</h3>
        <p class="mt-2 text-gray-600">R: Vous pouvez nous contacter via le formulaire de contact ou en envoyant un
        e-mail à support@stagefinder.com.</p>
      </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section>
      <h2 class="text-3xl font-semibold text-gray-800 mb-4">Nous Contacter</h2>
      <div class="bg-white p-6 rounded-lg shadow">
      <p class="text-gray-600">Si vous avez des questions supplémentaires, n'hésitez pas à nous contacter. Nous sommes
        là pour vous aider !</p>
      <ul class="mt-4 space-y-2">
        <!-- space-y-2 : espace entre les éléments de la liste -->
        <li class="flex items-center">
        <span class="text-gray-700">Email : support@stagefinder.com</span>
        </li>
        <li class="flex items-center">
        <span class="text-gray-700">Téléphone : +33 7 67 77 87 29</span>
        </li>
        <li class="flex items-center">
        <span class="text-gray-700">Adresse : 123 Rue de l'Exemple, 75000 Paris, France</span>
        </li>
      </ul>
      </div>
    </section>
    </div>
  </main>
@endsection