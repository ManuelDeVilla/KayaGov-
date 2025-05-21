<nav>
    <a href="{{ route('homepage') }}">Home</a>
    @guest
        <a href="{{ route('show.login') }}">Login</a>
        <a href="{{ route('show.register') }}">Register</a>
    @endguest

    @auth
        @if(Auth::user()->usertype === 'staff')
            <a href="{{ route('dashboard.staff') }}">Staff Dashboard</a>
        @elseif(Auth::user()->usertype === 'citizen')
            <a href="{{ route('dashboard.citizen') }}">Citizen Dashboard</a>
            <a href="{{ route('create.concerns') }}">Create Concern</a>
        
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button>Logout</button>
            </form>
        @else
            <a href="{{ route('show.login') }}">Login</a>
            <a href="{{ route('show.register') }}">Register</a>
        @endif
    @endauth
</nav>
