<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | {{ config('app.name', 'ERP') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    @include('layouts/sections/style')
    @yield('page-style')
</head>

<body>
    <div class="wrapper">
        <div style="background-color: #082150 ">
            <div class="d-flex" style="min-height: 100vh">
                <!-- /Left Text -->
                @if (file_exists(public_path('/login-page.jpg')))
                    <div class="d-none d-lg-flex col-lg-8 p-0 bg-image"
                        style="background-image: url('{{ config('app.url') }}//login-page.jpg'); background-size: cover;">
                    </div>
                @else
                    <div class="d-none d-lg-flex col-lg-8 p-0 bg-image"
                        style="background-image: url('https://w0.peakpx.com/wallpaper/169/871/HD-wallpaper-a-walk-in-nature-high-quality.jpg'); background-size: cover;">
                    </div>
                @endif

                <!-- Login -->
                <div class="d-flex col-12 col-lg-4 align-items-center p-sm-2 p-2">
                    <div class="w-px-400 mx-auto">
                        <div class="d-flex justify-content-center">
                            <!-- Logo -->
                            <div class="app-brand mb-3">
                                <img src="{{ asset('logo.ico') }}"
                                    alt="{{ config('app.description', 'Retail-ERP3') }} Logo"
                                    class="brand-image img-circle elevation-3" style="opacity: .8">
                            </div>
                        </div>

                        <!-- /Logo -->
                        <h3 class="mb-1 text-center text-white">{{ config('app.name') }}</h3>
                        <h5 class="mb-5 text-center text-white-50">{{ $buss->name }}</h5>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label text-white">Username</label>
                                <div class="bg-white rounded">
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter your email" autofocus required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-white">Password</label>
                                <div class="bg-white rounded">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                                    <label class="form-check-label text-white" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Sign in
                            </button>
                        </form>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>
    <!-- ./wrapper -->

    @include('layouts/sections/script')
    @yield('page-script')
</body>

</html>
