@extends('layouts.app')

@section('title', 'Plateforme de Développement')

@section('content')

<main>
  <section class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Plateforme de Développement</h1>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Éditeur de Code</h2>
          <p class="text-gray-600 mb-4">Un environnement d'édition avec coloration syntaxique, autosuggestions et aperçu en direct.</p>
          <div class="bg-gray-900 text-green-400 font-mono p-4 rounded">
            <!-- font-mono : monospacées sont celles où chaque caractère occupe exactement la même largeur -->
            &lt;div&gt;Hello, Dev!&lt;/div&gt;
            <!-- représente les élements < ou > -->
          </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Console</h2>
          <p class="text-gray-600 mb-4">Suivez l'exécution de vos scripts en temps réel avec des logs détaillés.</p>
          <div class="bg-black text-gray-100 font-mono p-4 rounded h-40 overflow-y-auto">
            <!-- overflow-y-auto : permet de faire défiler le contenu verticalement -->
            > npm run dev<br>
            ✔ Compilation terminée en 2.3s<br>
            Listening on http://localhost:3000
          </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Gestion de Projet</h2>
          <p class="text-gray-600 mb-4">Gardez une vue d'ensemble de vos tâches, fichiers, et versionnements.</p>
          <ul class="list-disc pl-5 text-gray-600">
            <li>Initialisation Git</li>
            <li>Suivi des tâches</li>
            <li>Historique des commits</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</main>

@endsection