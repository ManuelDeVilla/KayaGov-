
<aside class="sidebar">
    <div class="sidebar-section">
        <div class="logo">
            <a href="{{ route('homepage') }}">
                <img src="{{ asset('images/kayagov_logo.png') }}" alt="KayaGov Logo">
            </a>
        </div>
        <h3>Admin Panel</h3>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('citizens.concerns.index') }}" class="nav-link">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>All Concerns</span>
                </a>
            </li>
            <a href="{{ route('admin.staff_lists.index') }}" class="nav-link">  <i class="fas fa-exclamation-circle"></i>
                    <span>Government Staffs</span>
                </a>
            </li> 
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-check"></i>    
                    <span>Pending Staff Verifications</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.system-feedbacks.index') }}" class="nav-link">
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