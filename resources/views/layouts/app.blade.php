<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.3/flowbite.min.js"></script>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        @yield('content') 
    </div>
</body>
</html>