@include('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/staffs/staff-dashboard.css')
    @vite('resources/css/dashboard.css')
    @vite(entrypoints: 'resources/css/header.css')
    @vite('resources/css/staffs/staff-sidebar.css')
    @vite('resources/css/citizens/sidebar-styles.css')
    @vite('resources/css/footer.css')
    @vite('resources/js/sidebar.js')
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.staff-sidebar')
    </header>
    <div class="body">
        <div class="welcome-section">
            <h1>Welcome back, {{ auth()->user()->username }}!</h1>
            <p class="subtitle">Manage and respond to citizens' concerns</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-file-alt"></i>
                    <span>Total Concerns</span>
                </div>
                <div class="stat-number">{{ $totalConcerns }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-clock text-warning"></i>
                    <span>Pending</span>
                </div>
                <div class="stat-number">{{ $pendingConcerns }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-spinner text-info"></i>
                    <span>In Progress</span>
                </div>
                <div class="stat-number">{{ $inProgressConcerns }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-check-circle text-success"></i>
                    <span>Resolved</span>
                </div>
                <div class="stat-number">{{ $resolvedConcerns }}</div>
            </div>
        </div>
        

        <!-- Recent Activity Section -->
        <section class="concerns-list">
            <h2>Recent Activity</h2>
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
                            <a href="{{ route('citizens.concerns.details', ['id' => $concern->id]) }}" class="btn-view">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-concerns">
                    <i class="fas fa-inbox"></i>
                    <p>You haven't submitted any concerns yet.</p>
                    <a href="{{ route('create.concerns') }}" class="btn-primary">Submit Your First Concern</a>
                </div>
            @endif
        </section>
        
            <!-- Concerns List
            @if($concerns->count() > 0)
                <div class="concerns-list">
                    @foreach($concerns->take(5) as $concern)
                        <div class="concern-card">
                            <div class="concern-status {{ $concern->status }}">
                                @if($concern->status === 'resolved')
                                    <i class="fas fa-check-circle text-success"></i>
                                @elseif($concern->status === 'in_progress')
                                    <i class="fas fa-spinner text-info"></i>
                                @else
                                    <i class="fas fa-clock text-warning"></i>
                                @endif
                            </div>
                            <div class="concern-content">
                                <h3>{{ $concern->title }}</h3>
                                <p>{{ Str::limit($concern->description, 100) }}</p>
                                <div class="concern-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $concern->city_name }}</span>
                                    <span><i class="fas fa-calendar"></i> {{ $concern->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="concern-action">
                                <a href="{{ route('citizens.concerns.details', $concern->id) }}">View details »</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-concerns">
                    <i class="fas fa-inbox"></i>
                    <p>No concerns to display</p>
                </div>
            @endif
        </div> -->
    </div>
<footer>
    @include('includes.footer')
</footer>
</body>
</html>