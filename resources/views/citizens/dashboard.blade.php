
@include('layouts.app')
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
                    <p>{{ $concerns->where('status', 'pending')->count() }}</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon in-progress">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="summary-info">
                    <h3>In Progress</h3>
                    <p>{{ $concerns->where('status', 'in_progress')->count() }}</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon resolved">
                    <i class="fas fa-check"></i>
                </div>
                <div class="summary-info">
                    <h3>Resolved</h3>
                    <p>{{ $concerns->where('status', 'resolved')->count() }}</p>
                </div>
            </div>
        </section>

        <!-- Concerns List Section -->
        <section class="concerns-list">
            <h2>My Concerns</h2>
            @if($concerns->count() > 0)
                @foreach($concerns as $concern)
                    <div class="concern-item">
                        <div class="concern-status {{ strtolower(str_replace(' ', '-', $concern->status)) }}">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="concern-info">
                            <h3>{{ $concern->title }}</h3>
                            <p class="concern-meta">
                                <span><i class="fas fa-map-marker-alt"></i> {{ $concern->city_name }}</span>
                                <span><i class="fas fa-calendar"></i> {{ $concern->created_at ? $concern->created_at->format('M d, Y') : 'No date' }}</span>
                                <span><i class="fas fa-tag"></i> {{ ucfirst($concern->category) }}</span>
                            </p>
                            <p class="concern-description">{{ Str::limit($concern->description, 100) }}</p>
                        </div>
                        <div class="concern-actions">
                            <span class="status-badge {{ strtolower(str_replace(' ', '-', $concern->status)) }}">
                                {{ ucfirst($concern->status) }}
                            </span>
                            <a href="#" class="btn-view">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-concerns">
                    <i class="fas fa-inbox"></i>
                    <p>You haven't submitted any concerns yet.</p>
                    <a href="#" class="btn-primary">Submit Your First Concern</a>
                </div>
            @endif
        </section>
    </div>
</body>
</html>