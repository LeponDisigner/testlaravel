<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> {{ config('app.name') }}-@yield('titre') </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ Asset('Assets/app.css') }}">
    </head>
    <body>
         {{-- bar de navigation --}}
        @include('navbar/nav_bar')


        {{-- tout nos contenu seront afficher ici --}}
        @yield('content')


        {{-- ici c'est notre foother --}}

        @include('navbar/footer')

         {{-- le script javascript --}}
        @include('script')

    </body>
</html>
