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
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <input type="hidden" id="username" name="usertype" value="citizen">

                    <div class="input">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Username...">
                    </div>

                    <div class="input">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Email...">
                    </div>

                    <div class="input">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender">
                            <option disabled selected>Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="input">
                        <label for="">Region</label>
                        <div class="selector-wrapper" id="region-selector">
                            <div class="selector">
                                <span class="selector_text">Select A Region</span>
                                <span id="arrow">&#129131;</span>
                            </div>

                            <div class="options">
                                <input type="hidden" class="selector_type" value="region">
                                <input type="hidden" class="input" name="region">
                                <div class="search-wrapper">
                                    <input type="text" class="search-input" placeholder="Search a City...">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input">
                        <label for="">Province</label>
                        <div class="selector-wrapper" id="province-selector">
                            <div class="selector">
                                <span class="selector_text">Select a Province</span>
                                <span id="arrow">&#129131;</span>
                            </div>

                            <div class="options">
                                <input type="hidden" class="selector_type" value="province">
                                <input type="hidden" class="input" name="province">
                                <div class="search-wrapper">
                                    <input type="text" class="search-input" placeholder="Search a City...">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input">
                        <label for="">City</label>
                        <div class="selector-wrapper">
                            <div class="selector">
                                <span class="selector_text">Select a City</span>
                                <span id="arrow">&#129131;</span>
                            </div>

                            <div class="options">
                                <input type="hidden" class="selector_type" value="city">
                                <input type="hidden" class="input" name="city">
                                <div class="search-wrapper">
                                    <input type="text" class="search-input" placeholder="Search a City...">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password...">
                    </div>

                    <div class="input">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
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
    @vite('resources/js/register-options.js')
</body>
</html>