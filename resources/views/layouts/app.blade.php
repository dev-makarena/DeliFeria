<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link href="{{ asset('css/bulma.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/functions.css') }}" rel="stylesheet">

    <link href="{{ asset('css/modal.css') }}" rel="stylesheet">
    <link href="{{ asset('css/targetSession.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/form.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/carrito.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/productClient.css') }}">

    <!-- CARRUSEL -->
    <link rel="stylesheet" href="{{ asset('slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('slick/slick-theme.css') }}">

    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}" defer></script>


    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('slick/slick.js') }}"></script>

</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts


</body>

</html>