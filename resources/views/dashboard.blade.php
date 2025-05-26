
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/dashboard.css')
    @vite('resources/css/header.css')
    @vite('resources/css/citizens/sidebar-styles.css')
    @vite('resources/js/sidebar.js')
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.sidebar')
    </header>
    <div class="body">
        <section class="header-section">
            <h1>Dashboard</h1>
            <p>Welcome to your dashboard, {{ auth()->user()->username }}!</p>
        </section>

        <!-- Summary Section -->
        <section class="summary-section">
            <div class="summary-card">
                <div class="summary-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="summary-info">
                    <h3>Pending</h3>
                    <p>{{ $concerns->where('status', 'Pending')->count() }}</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon in-progress">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="summary-info">
                    <h3>In Progress</h3>
                    <p>{{ $concerns->where('status', 'In Progress')->count() }}</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon resolved">
                    <i class="fas fa-check"></i>
                </div>
                <div class="summary-info">
                    <h3>Resolved</h3>
                    <p>{{ $concerns->where('status', 'Resolved')->count() }}</p>
                </div>
            </div>
        </section>

        <!-- Concerns List Section -->
        <section class="concerns-list">
            <h2>My Concerns</h2>
            @foreach($concerns as $concern)
                <div class="concern-item">
                    <div class="concern-status {{ strtolower($concern->status) }}">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="concern-info">
                        <h3>{{ $concern->title }}</h3>
                        <p class="concern-meta">
                            <span><i class="fas fa-map-marker-alt"></i> {{ $concern->city }}</span>
                            <span><i class="fas fa-calendar"></i> {{ $concern->created_at->format('M d, Y') }}</span>
                        </p>
                    </div>
                    <div class="concern-actions">
                        <a href="{{ route('citizens.concerns.details', $concern->id) }}" class="btn-view">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
</body>
</html>