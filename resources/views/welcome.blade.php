<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Laravel</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

    </head>
    <body>
        <div>

            {{-- @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif --}}


            <div id="app">   

                <nav-bar></nav-bar>

                <div class="card">
                        <router-view>
                        </router-view>
                </div>
                
            </div> 


        </div>

        <script src="{{ asset('js/app.js') }}"></script>

    </body>
</html>
