
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/admin/admin-dashboard.css')
    @vite('resources/css/header.css')
    @vite('resources/css/admin/admin-sidebar.css')
    @vite('resources/js/sidebar.js')
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.admin-sidebar')
    </header>
    <div class="body">
        <div class="welcome-section">
            <h1>Admin Dashboard</h1>
            <p class="subtitle">Manage staff verification and content moderation</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-user-shield"></i>
                    <span>Pending Staff Verifications</span>
                </div>
               
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-users"></i>
                    <span>Total Staff Members</span>
                </div>
                <div class="stat-number">{{ $totalStaff }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Total Citizen</span>
                </div>
                <div class="stat-number">{{ $totalCitizens }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-check-circle"></i>
                    <span> Total Concerns</span>
                </div>
                <div class="stat-number">{{ $totalConcerns }}</div>
            </div>
               <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-check-circle"></i>
                    <span> Pending Concerns</span>
                </div>
                <div class="stat-number">{{ $pendingConcerns }}</div>
            </div>
        </div>
      
    </div>
</body>
</html>