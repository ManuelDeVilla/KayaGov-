
<aside class="sidebar">
    <div class="sidebar-section">
        <div class="logo">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/kayagov_logo.png') }}" alt="KayaGov Logo">
            </a>
        </div>
        <h3>Admin Panel</h3>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('concern-list') }}" class="nav-link">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>All Concerns</span>
                </a>
            </li>

            <li>
                <a href="{{ route('staff-lists') }}" class="nav-link">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Government Staffs</span>
                </a>
            </li>

            </li>

            <!-- Create Account -->
             <li class="nav-item">
                <a href="{{ route('show.admin.create') }}" class="nav-link">
                    <i class="fas fa-user-check"></i>    
                    <span>Create Account</span>
                </a>
            </li>

            <!-- List of Staff Verification -->
            <li class="nav-item">
                <a href="{{ route('list.staff-verification') }}" class="nav-link">
                    <i class="fas fa-user-check"></i>    
                    <span>Pending Staff Verifications</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('feedback') }}" class="nav-link">
                    <i class="fas fa-comments"></i>
                    <span>System Feedbacks</span>
                </a>      
            </li>
        </ul>
    </div>
    
    <div class="sidebar-section">
        <h3>Account</h3>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.profile') }}" class="nav-link">
                    <i class="fas fa-user"></i>
                    <span>User Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>