@extends('layouts.app')

@section('title', 'Trouver un Expert')

@section('content')
<main>
  <section class="hero bg-blue-100 py-16">
    <!--hero : section d'introduction -->
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-4xl font-bold text-gray-800 mb-4">Trouvez un expert pour vos projets</h1>
      <p class="text-lg text-gray-600 mb-6">Que vous ayez besoin d'un conseil en stratégie, d'une expertise technique ou d'un accompagnement personnalisé, nos experts sont là pour vous aider.</p>
      <form class="search-form flex justify-center gap-4">
        <!--search-form : formulaire de recherche -->
        <input type="text" placeholder="Recherchez un domaine d'expertise" class="border border-gray-300 rounded px-4 py-2 w-1/2">
        <button type="submit" class="bg-[#5A8E95] text-white px-6 py-2 rounded hover:bg-[#5DE0E6]">Rechercher</button>
      </form>
    </div>
  </section>

  <section class="experts-list bg-white py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-semibold text-center text-gray-800 mb-12">Nos Experts</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="expert-card bg-gray-50 p-6 rounded-lg shadow text-center">
          <img src="{{ asset('storage/images/benjamin_bourlet.jpg') }}" alt="Expert 1" class="w-24 h-24 mx-auto rounded-full mb-4">
          <h3 class="text-xl font-medium text-gray-800">Bourlet Benjamin</h3>
          <p class="text-gray-600 text-sm mt-2 mb-4">Expert en stratégie digitale et transformation numérique.</p>
          <a href="#" class="text-[#5A8E95] hover:underline">Voir le profil</a>
        </div>
        <div class="expert-card bg-gray-50 p-6 rounded-lg shadow text-center">
          <img src="{{ asset('storage/images/diego_bortolussi.jpg') }}" alt="Expert 2" class="w-24 h-24 mx-auto rounded-full mb-4">
          <h3 class="text-xl font-medium text-gray-800">Bortolussi Diego</h3>
          <p class="text-gray-600 text-sm mt-2 mb-4">Consultant en marketing et communication, avec plus de 10 ans d'expérience.</p>
          <a href="#" class="text-[#5A8E95] hover:underline">Voir le profil</a>
        </div>
        <div class="expert-card bg-gray-50 p-6 rounded-lg shadow text-center">
          <img src="{{ asset('storage/images/argan_da_costa.jpg') }}" alt="Expert 3" class="w-24 h-24 mx-auto rounded-full mb-4">
          <h3 class="text-xl font-medium text-gray-800">Da Costa Argan</h3>
          <p class="text-gray-600 text-sm mt-2 mb-4">Spécialiste en technologies de l'information et cybersécurité.</p>
          <a href="#" class="text-[#5A8E95] hover:underline">Voir le profil</a>
        </div>
        <div class="expert-card bg-gray-50 p-6 rounded-lg shadow text-center">
          <img src="{{ asset('storage/images/maxime_moysset.jpg') }}" alt="Expert 4" class="w-24 h-24 mx-auto rounded-full mb-4">
          <h3 class="text-xl font-medium text-gray-800">Moysset Maxime</h3>
          <p class="text-gray-600 text-sm mt-2 mb-4">Experte en développement web et solutions e-commerce.</p>
          <a href="#" class="text-[#5A8E95] hover:underline">Voir le profil</a>
        </div>
      </div>
    </div>
  </section>

  <section class="testimonial bg-gray-100 py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-semibold text-center text-gray-800 mb-12">Témoignages</h2>
      <div class="space-y-8 max-w-3xl mx-auto">
        <blockquote class="border-l-4 border-blue-500 pl-4 text-gray-700 italic">
          <p>"Grâce à l'expertise de Argan et Diego, nous avons réussi à transformer notre business model."</p>
          <footer class="text-right text-sm mt-2">– Orange cyberdéfense</footer>
        </blockquote>
        <blockquote class="border-l-4 border-blue-500 pl-4 text-gray-700 italic">
          <p>"Benji et Maxime nous a aidés à repenser notre stratégie digitale. Des vrai professionnels !"</p>
          <footer class="text-right text-sm mt-2">– Airbus</footer>
        </blockquote>
      </div>
    </div>
  </section>

  <section class="call-to-action bg-gradient-to-tl from-[#5A8E95] to-[#5DE0E6] py-16 text-white text-center rounded-lg m-10">
    <!--call-to-action : section d'appel à l'action -->
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold mb-4">Prêt à transformer votre projet ?</h2>
      <p class="mb-6 text-lg">Contactez-nous dès aujourd'hui pour en savoir plus sur nos experts et découvrir comment nous pouvons vous accompagner.</p>
      <a href="#" class="btn bg-white text-[#5A8E95] font-semibold px-6 py-3 rounded hover:bg-gray-100">Contactez-nous</a>
    </div>
  </section>
</main>
@endsection