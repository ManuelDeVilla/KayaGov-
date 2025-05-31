<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KayaGov?</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/header.css')
    @vite('resources/css/login.css')
</head>
<body>
    
    <div class="body">
        <section class="form">
            <div class="form-header">
                <h1>KayaGov?</h1>
                <p class="header">Sign In To Your Account</p>
                <p>or <a class="sign-up" href="{{ route('register') }}">create a new account</a></p>
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

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    
                    <div class="input">
                        <label for="">Email</label>
                        <input type="email" name="email" placeholder="Email...">
                    </div>
                    
                    <div class="input">
                        <label for="">Password</label>
                        <input type="password" name="password" placeholder="Password...">
                    </div>

                    <div class="button-holder">
                        <button class="submit-button" type="submit">Sign in</button>
                    </div>
                </form>
            </div>
        </section>

        <section class="image-section">
            <img src="{{ asset('images/login.png') }}" alt="">
        </section>
    </div>
</body>
</html>