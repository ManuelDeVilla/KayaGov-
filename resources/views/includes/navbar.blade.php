<nav>
    <a href="{{ route('homepage') }}">Home</a>
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
    @endauth
</nav>
