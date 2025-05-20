<nav>
    <a href="{{ route('homepage') }}">Home</a>
<<<<<<< HEAD
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
=======
    @auth
        @if(Auth::user()->usertype === 'staff')
            <a href="{{ route('dashboard.staff') }}">Staff Dashboard</a>
        @elseif(Auth::user()->usertype === 'citizen')
            <a href="{{ route('dashboard.citizen') }}">Citizen Dashboard</a>
        @endif
        <a href="{{ route('logout') }}">Logout</a>
    @else
        <a href="{{ route('show.login') }}">Login</a>
        <a href="{{ route('show.register') }}">Register</a>
>>>>>>> 9a157605ed4fdea9f92b5e03ee323065a0d157a4
    @endauth
</nav>
