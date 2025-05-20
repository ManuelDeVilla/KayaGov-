<nav>
    <a href="{{ route('homepage') }}">Home</a>
    @guest
        <a href="{{ route('show.login') }}">Login</a>
        <a href="{{ route('show.register') }}">Register</a>
    @endguest

    @auth
        <a href="{{ route('create.concerns') }}">Create Concern</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button>Logout</button>
        </form>
    @endauth
</nav>
