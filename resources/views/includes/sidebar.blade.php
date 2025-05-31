 
    <aside class="sidebar">
            <div class="sidebar-section">
                <div class="logo">
                <a href="{{ route('concern-list') }}">
                    <img src="{{ asset('images/kayagov_logo.png') }}" alt="KayaGov Logo">
                </a>
            </div>
                <h3>Main</h3>
                <ul class="nav-menu">
                    @auth
                        @if(auth()->user()->usertype === 'citizen' || auth()->user()->usertype === 'staff')
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="fas fa-chart-line"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @endif
                    @endauth
                    <li class="nav-item">
                        <a href="{{ route('concern-list')}}" class="nav-link">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Concerns</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('create.concerns')}}" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Create Concern</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-list"></i>
                            <span>My Concerns</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('show.create-account') }}" class="nav-link">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>Create Account</span>
                        </a>
                    </li>

                    @auth
                        @if (Auth::user()->usertype == 'admin')
                            <li class="nav-item">
                                <a href="{{ route('list.staff-verification') }}" class="nav-link">
                                    <i class="fa-solid fa-user-plus"></i>
                                    <span>Staff Verification</span>
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
            
            <div class="sidebar-section">
            <h3>Account</h3>
            <ul class="nav-menu">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('show.login') }}" class="nav-link">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('show.register') }}" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Register</span>
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <a href="{{ route('user-profile') }}" class="nav-link">
                            <i class="fas fa-user"></i>
                            <span>User Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" method="POST" style="margin: 0;" class="nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </aside>