<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.3/flowbite.min.js"></script>
</head>
<body>
    <div class="grid md:grid-cols-2 grid-cols-1 place-items-center md:gap-6 gap-2 m-4">
        <div class="p-4">
            <H1 class="m-4 text-3xl text-[#5A8E95] text-left font-extrabold ">A PROPOS DE NOUS</H1>
            <p class="p-4 text-xl xl:mr-50 rounded-2xl">À Toulouse, nous étions quatre amis ingénieurs passionnés par le web et l'entrepreneuriat : Benjamin, Maxime, Diego et Argan. Chacun d'entre nous avait connu des difficultés pour trouver un stage ou une alternance pendant nos études, et nous étions déterminés à changer les choses pour les générations futures.</p>
            <br>
            <p class="p-4  text-xl xl:mt-10 xl:ml-50 rounded-2xl">Un jour, lors d'une réunion de travail, nous avons eu une idée révolutionnaire : créer une plateforme en ligne qui simplifierait la recherche de stages et d'alternances pour les étudiants. "Nous pourrions centraliser toutes les offres, fournir des outils pour optimiser les candidatures et offrir des conseils personnalisés," avons-nous dit avec conviction.</p>
        </div>
        <div>
            <img class="rounded-2xl" src="stockage/images/img_1_about.avif" alt="">
        </div>
    </div>


    <div id="controls-carousel" class="relative w-full mt-50" data-carousel="static">
        <!-- Carousel wrapper -->
        <div class="relative h-screen overflow-hidden rounded-lg md:h-96">
             <!-- Item 1 -->
             <div class="hidden duration-700 ease-in-out border-2 rounded-2xl" data-carousel-item>
                <div class="grid md:grid-cols-2 grid-cols-1 gap-10 md:gap-0 place-items-center place-text-center absolute w-6/7 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                    <img class="rounded-2xl animate-bounce" src="stockage/images/benjamin.jpg" width="300" height="300">
                    <p class="text-xl m-4">Benjamin, en tant que chef de design, s'occupa de l'identité visuelle et de l'interface utilisateur. "Il est crucial que notre plateforme soit non seulement fonctionnelle, mais également agréable à utiliser. Je vais créer une identité visuelle qui reflète notre mission et nos valeurs," ajouta-t-il avec passion.</p>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out border-2 rounded-2xl" data-carousel-item>
                <div class="grid md:grid-cols-2 grid-cols-1 gap-10 md:gap-0 place-items-center place-text-center absolute w-6/7 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                    <img class="justify-content-center rounded-2xl animate-spin" src="stockage/images/maxime.jpg" width="300" height="300">
                    <p class="text-xl m-4" >Maxime, notre développeur talentueux, se montra tout de suite enthousiaste : "Je peux m'occuper de la conception technique. Nous utiliserons les technologies les plus récentes pour garantir une expérience utilisateur fluide et intuitive."</p>
                </div>
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out border-2 rounded-2xl" data-carousel-item>
                <div class="grid md:grid-cols-2 grid-cols-1 gap-10 md:gap-0 place-items-center place-text-center absolute w-6/7 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                    <img class="justify-content-center rounded-2xl animate-bounce" src="stockage/images/diego.jpg" width="300" height="300">
                    <p class="text-xl m-4" >Diego, quant à lui, avait un don pour le marketing et la communication. "Je m'occuperai de la stratégie de communication et du référencement. Il faut que notre plateforme soit visible et attire à la fois les étudiants et les entreprises," expliqua-t-il.</p>
                </div>
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out border-2 rounded-2xl" data-carousel-item>
                <div class="grid md:grid-cols-2 grid-cols-1 gap-10 md:gap-0 place-items-center place-text-center absolute w-6/7 -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                    <img class="justify-content-center rounded-2xl animate-spin" src="stockage/images/argan.jpg" width="300" height="300">
                    <p class="text-xl m-4" >Argan, notre chef du développement, proposa d'élaborer les fonctionnalités avancées et la structure technique du site. "Il est essentiel que notre plateforme soit robuste et évolutive. Je vais m'assurer que tout fonctionne parfaitement et que nous puissions intégrer de nouvelles fonctionnalités au fil du temps," ajouta-t-il avec détermination.</p>
                </div>
            </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/5 group-focus:ring-4 group-focus:ring-black group-focus:outline-none">
                <img src="stockage/images/left_arrow_carousel.svg" >
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-4 group-focus:ring-dark group-focus:outline-none">
                <img src="stockage/images/right_arrow_carousel.svg" >
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>


    <div class="grid md:grid-cols-2 grid-cols-1 place-items-center gap-6 m-4 mt-50">
            <img src="stockage/images/Logo.png" class="h-full w-3/4 rounded-2xl">
            <p class="border-10 border-[#5A8E95] p-4 rounded-2xl">Le projet, que nous avons baptisé "StageFinder", prit rapidement forme. Grâce à notre expertise et à notre collaboration, nous avons développé une plateforme innovante, dotée de fonctionnalités avancées telles que des filtres de recherche personnalisables, des alertes d'offres, et des conseils pour réussir les entretiens.</p>
        
            <p class="border-10 border-[#5A8E95] p-4 rounded-2xl">Peu après le lancement, nous avons été contactés par le CESI, une école d'ingénieurs réputée, qui souhaitait intégrer notre plateforme à leur réseau. Cette collaboration renforça encore davantage notre crédibilité et permit à de nombreux étudiants de profiter des opportunités offertes par StageFinder.</p>
            <img src="stockage/images/cesi.png" class="h-full w-full ">
            <div class="grid grid-cols-2 place-items-center gap-x-2 md:gap-x-10">
    
                <p class="md:text-4xl text-2xl text-blue-500 font-extrabold">10 Milliers</p>
                <p class="md:text-4xl text-2xl text-blue-500 font-extrabold">435 Millions</p>
                <p class="text-sm text-black">de profils entreprise</p>
                <p class="text-sm text-black">Nombre moyen d'offre d'emploie</p>
        
            </div>
            <p class="border-10 border-[#5A8E95] p-4 rounded-2xl">StageFinder rencontra un succès immédiat, attirant des milliers d'étudiants en quête de stages et d'alternances, ainsi que des entreprises à la recherche de jeunes talents. La plateforme devint rapidement une référence incontournable, permettant à de nombreux étudiants de trouver des opportunités professionnelles.</p>
            <p class="border-10 border-[#5A8E95] p-4 rounded-2xl">Grâce à notre vision et à notre détermination, nous avons transformé notre expérience personnelle en une solution innovante et utile pour des milliers d'étudiants. StageFinder devint plus qu'une simple plateforme : c'était un outil de réussite, un espace de partage et une communauté solidaire.</p>  
            <img src="stockage/images/collaboration_about.avif" alt="">
    </div>
</body>
</html>