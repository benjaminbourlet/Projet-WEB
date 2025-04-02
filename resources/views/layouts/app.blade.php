<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Stage Finder est une plateforme dédiée à la recherche de stages pour les étudiants. Trouvez des opportunités de stage adaptées à vos compétences et intérêts.">
    <title>@yield('title', 'Stage Finder')</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.3/flowbite.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/nouislider@15.6.1/dist/nouislider.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.6.1/dist/nouislider.min.js"></script>
</head>
<body class="container max-w-full">

    {{-- Header inclus ici --}}
    @include('partials.header')

    {{-- Contenu dynamique des pages --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer inclus ici --}}
    @include('partials.footer')

</body>
</html>
