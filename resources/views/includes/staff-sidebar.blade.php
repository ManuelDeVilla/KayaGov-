 
    <aside class="sidebar">
            <div class="sidebar-section">
                <div class="logo">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/kayagov_logo.png') }}" alt="KayaGov Logo">
                </a>
            </div>
                <h3>Main</h3>
                <ul class="nav-menu">
                    @if(auth()->user()->usertype === 'citizen' || auth()->user()->usertype === 'staff')
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="fas fa-chart-line"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @endif
                    
                    <li class="nav-item">
                        <a href="{{ route('concern-list')}}" class="nav-link">
                            <i class="fas fa-bullhorn"></i>
                            <span>Concerns</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('staffs.inprogress')}}" class="nav-link">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>In Progress Concerns</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('staffs.resolved')}}" class="nav-link">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Resolved Concerns</span>
                        </a>
                    </li>
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
                        <a href="{{ route('staff.profile') }}" class="nav-link">
                            <i class="fas fa-user"></i>
                            <span>User Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" method="POST" style="margin: 0;" class="nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                    </li>
                @endauth
            </ul>
        </div>
    </aside>