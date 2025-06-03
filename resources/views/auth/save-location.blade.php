<?php

use Illuminate\Support\Facades\Auth;

if (Auth::check() && Auth::user()->usertype == 'admin') {
    $route = route('create.admin.location');
} else {
    $route = route('register.location');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KayaGov?</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/header.css')
    @vite('resources/css/register/dropdowns.css')
    @vite('resources/css/register/register.css')
</head>
<body>

    <div class="body">

        <div class="form">
            <div class="form-header">
                <h1>KayaGov?</h1>
                <p class="header">Create a New Account</p>
                <p>or <a class="sign-in" href="{{ route('show.login') }}">sign in to an existing account</a></p>
            </div>

            <div class="form-card">

                <div class="form-header">
                    <p class="header">Please Input Your Location</p>
                </div>
                <form action="{{ $route }}" method="post" id="form">
                    @csrf
                    
                    <div class="input">
                        <label for="">Province</label>
                        <div class="selector-wrapper" id="province-selector">
                            <div class="selector">
                                <span class="selector_text">Select a Province</span>
                                <span id="arrow">&#129131;</span>
                            </div>

                            <div class="options">
                                <input type="hidden" class="selector_type" value="province">
                                <input type="hidden" class="input" id="province-input" name="province" value="">
                                <div class="search-wrapper">
                                    <input type="text" class="search-input" placeholder="Search a Province..." id="province-search">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>

                        <p id="province-label" class="error-handler">Please Input Your Province.</p>
                    </div>

                    <div class="input">
                        <label for="">City</label>
                        <div class="selector-wrapper" id="city-selector">
                            <div class="selector">
                                <span class="selector_text">Select a City</span>
                                <span id="arrow">&#129131;</span>
                            </div>

                            <div class="options">
                                <input type="hidden" class="selector_type" value="city">
                                <input type="hidden" class="input" name="city" id="city-input" value="">
                                <div class="search-wrapper">
                                    <input type="text" class="search-input" placeholder="Search a City..." id="city-search">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>

                        <p id="city-label" class="error-handler">Please Input Your City.</p>
                    </div>

                    <div class="button-holder">
                        <button class="submit-button" type="submit">Create Account</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="image-section">
            <img src="{{ asset('images/register.png') }}" alt="">
        </div>

        @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
    </div>
    
    <script>
        const getShowSelector = "{{ route('get.show.values') }}";
        const getSearchSelector = "{{ route('get.search.values') }}";
    </script>
    @vite('resources/js/location/register-options.js')
    @vite('resources/js/location/error-checker.js')
</body>
</html>