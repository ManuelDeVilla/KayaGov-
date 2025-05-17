<nav>
    <a href="{{ route('homepage') }}">Home</a>
    <a href="{{ route('show.login') }}">Login</a>
    <a href="{{ route('show.register') }}">Register</a>
    <a href="">Logout</a>
</nav>

<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<div class="main-header">
    <div class="logo" href="{{ route('homepage') }}">KayaGov</div>
    <nav class="nav-links">
        <a href="#">Logout</a>
    </nav>
</div>