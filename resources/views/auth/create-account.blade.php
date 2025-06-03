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

                <!-- Error Handler -->
                <div class="form-handler-wrapper">
                    @if ($errors->any())
                        <ul class="form-handler">
                            <li class="error-header">Error Found</li>
                            @foreach ($errors->all() as $error)
                                <li class="errors">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                
                <form id="form" action="{{ $route }}" method="post">
                    @csrf

                    <div class="input">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Username...">

                        <p id="username-label" class="error-handler">Username Should be 3 - 16 characters.</p>
                    </div>

                    <div class="input">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Email...">
                        
                        <p id="email-label" class="error-handler hidden">Please input your Email Mah Nigg@.</p>
                    </div>

                    <div class="input">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender">
                            <option value="" disabled selected>Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        
                        <p id="gender-label" class="error-handler hidden">Please Select a Gender Mah Nigg@.</p>
                    </div>

                    <div class="input">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password...">
                        
                        <p id="password-label" class="error-handler">Password should be 6 - 20 characters.</p>
                    </div>

                    <div class="input">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                        
                        <p id="password_confirmation_label" class="error-handler hidden">Password do not match.</p>
                    </div>

                    <div class="input">
                        <label for="usertype">Account Type</label>
                        <input id="usertype" type="hidden" name="usertype" value="">

                        <div class="usertype-button-wrapper">
                            <div id="government-button" class="button-wrapper">
                                <p>Government Staff</p>
                            </div>

                            <div id="admin-button" class="button-wrapper">
                                <p>Admin</p>
                            </div>
                        </div>
                        
                        <p id="usertype-label" class="error-handler hidden">Please choose the type of account to be created.</p>
                    </div>

                    <div class="button-holder">
                        <button class="submit-button" type="submit">Next</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="image-section">
            <img src="{{ asset('images/register.png') }}" alt="">
        </div>
    </div>
    
    <script>
        const getShowSelector = "{{ route('get.show.values') }}";
        const getSearchSelector = "{{ route('get.search.values') }}";
    </script>
    @vite('resources/js/create-account.js')
</body>
</html>