<div class="main-header">
        <button class="menu-button d-lg-none">
    <i class="fas fa-bars"></i>
</button>
    <nav class="nav-links">
        <div class="user-profile">
            <img src="{{ asset('images/circle-user-round.svg') }}" alt="User Icon" class="user-icon">
            @auth
                <span class="user-name">{{ auth()->user()->username }}</span>
            @else
                <span class="user-name">Guest</span>
            @endauth
        </div>
    
    </nav>
</div>