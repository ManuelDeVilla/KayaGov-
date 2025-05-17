<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KayaGov?</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/login.css')
</head>
<body>
    <header>
        @include('includes.navbar')
    </header>
    
    <div class="body">
        <section class="form">
            <div class="form-header">
                <h1>KayaGov?</h1>
                <p class="header">Sign In To Your Account</p>
                <p>or <a class="sign-up" href="{{ route('register') }}">create a new account</a></p>
            </div>

            <div class="form-card">
                <form action="" method="post">
                    @csrf
                    
                    <div class="input">
                        <label for="">Email</label>
                        <input type="email" placeholder="Email...">
                    </div>
                    
                    <div class="input">
                        <label for="">Password</label>
                        <input type="password" placeholder="Password...">
                    </div>

                    <div class="button-holder">
                        <button class="submit-button" type="submit">Create Account</button>
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