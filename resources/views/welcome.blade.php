@extends('layouts.app')

@section('title', 'Accueil')

@include('partials.header')

<body class="bg-white">
    <h1 class="text-4xl font-bold text-black text-center pt-20"> Stage - Entreprise à la une </h1>

    <div class="m-4 mt-8">
        <div x-data="{
            slides: [
                @foreach ($topCompanies as $company)
                {
                    imgSrc: '{{ $company->logo ? asset("storage/" . $company->logo) : asset("storage/images/LogoDQF.jpg") }}',
                    imgAlt: 'Logo de {{ $company->name }}',
                    title: '{{ $company->name }}',
                    description: '{{ $company->offers_count }} offres publiées'
                },
                @endforeach
            ],
            currentSlideIndex: 1,
            previous() {
                if (this.currentSlideIndex > 1) {
                    this.currentSlideIndex--;
                } else {
                    this.currentSlideIndex = this.slides.length;
                }
            },
            next() {
                if (this.currentSlideIndex < this.slides.length) {
                    this.currentSlideIndex++;
                } else {
                    this.currentSlideIndex = 1;
                }
            }
        }" class="relative w-full overflow-hidden">
            
            <!-- Bouton précédent -->
            <button type="button"
                class="absolute left-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 items-center justify-center bg-gray-500 p-2 text-white transition hover:bg-gray-700"
                aria-label="previous slide" x-on:click="previous()">
                &lt;
            </button>

            <!-- Bouton suivant -->
            <button type="button"
                class="absolute right-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 items-center justify-center bg-gray-500 p-2 text-white transition hover:bg-gray-700"
                aria-label="next slide" x-on:click="next()">
                &gt;
            </button>

            <!-- Slides -->
            <div class="relative min-h-[50svh] w-full">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-cloak x-show="currentSlideIndex == index + 1" class="absolute inset-0"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90">

                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 text-white text-center p-8">
                            <h3 class="text-3xl font-bold" x-text="slide.title"></h3>
                            <p class="text-lg" x-text="slide.description"></p>
                        </div>

                        <img class="absolute w-full h-full object-cover" x-bind:src="slide.imgSrc" x-bind:alt="slide.imgAlt" />
                    </div>
                </template>
            </div>

            <!-- Indicateurs -->
            <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button class="w-3 h-3 rounded-full bg-white opacity-50 hover:opacity-100"
                        x-bind:class="currentSlideIndex === index + 1 ? 'bg-gray-800' : 'bg-white'"
                        x-on:click="currentSlideIndex = index + 1"></button>
                </template>
            </div>
        </div>
    </div>
</body>

@include('partials.footer')