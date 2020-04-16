<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            .level {
                display: flex;
                align-items: center;
            }

            .flex {
                flex: 1;
            }

            [v-cloak] {
                display: none;
            }

            .ml-a {
                margin-left: auto;
            }

            .ais-highlight > em {
                background: yellow;
                font-style: normal;
            }
        </style>
        <script>
            window.app = {!! json_encode([
                'signedIn' => auth()->check(),
                'user' => auth()->user(),
            ]) !!}
        </script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.1/trix.css" rel="stylesheet">

        @stack('head')
    </head>
    <body>
        <div id="app">
            @include('layouts._nav')

            <main class="py-4">
                @yield('content')
            </main>

            <flash message="{{ session('flash') }}"></flash>
        </div>
        @stack('scripts')
    </body>
</html>
