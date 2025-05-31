@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Feedbacks - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/admin/system-feedbacks.css')
    @vite('resources/css/header.css')
    @vite('resources/css/admin/admin-sidebar.css')
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.admin-sidebar')
    </header>
    
    <div class="body">
        <div class="page-header">
            <h1>System Feedbacks</h1>
            <p class="subtitle">Manage feedback from citizens and government staff</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-comments"></i>
                    <span>Total Feedbacks</span>
                </div>
                <div class="stat-number">{{ $stats['total'] }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-users"></i>
                    <span>From Citizens</span>
                </div>
                <div class="stat-number">{{ $stats['citizen'] }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-user-shield"></i>
                    <span>From Government</span>
                </div>
                <div class="stat-number">{{ $stats['government'] }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <i class="fas fa-clock"></i>
                    <span>Pending Review</span>
                </div>
                <div class="stat-number">{{ $stats['pending'] }}</div>
            </div>
        </div>

        <!-- Filters -->
<div class="filters-section">
    <form method="GET" action="{{ route('admin.system-feedbacks.index') }}" class="filters-form">
        <div class="filter-group">
            <label for="filter">Source:</label>
            <select name="filter" id="filter">
                <option value="all" {{ request('filter') == 'all' || !request('filter') ? 'selected' : '' }}>All Sources</option>
                <option value="citizen" {{ request('filter') == 'citizen' ? 'selected' : '' }}>Citizens</option>
                <option value="government" {{ request('filter') == 'government' ? 'selected' : '' }}>Government Staff</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="type">Type:</label>
            <select name="type" id="type">
                <option value="all" {{ request('type') == 'all' || !request('type') ? 'selected' : '' }}>All Types</option>
                <option value="bug_report" {{ request('type') == 'bug_report' ? 'selected' : '' }}>Bug Report</option>
                <option value="feature_request" {{ request('type') == 'feature_request' ? 'selected' : '' }}>Feature Request</option>
                <option value="general_feedback" {{ request('type') == 'general_feedback' ? 'selected' : '' }}>General Feedback</option>
                <option value="complaint" {{ request('type') == 'complaint' ? 'selected' : '' }}>Complaint</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="rating">Rating:</label>
            <select name="rating" id="rating">
                <option value="all" {{ request('rating') == 'all' || !request('rating') ? 'selected' : '' }}>All Ratings</option>
                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
            </select>
        </div>
        
        <div class="filter-actions">
            <button type="submit" class="filter-btn apply-btn">
                <i class="fas fa-filter"></i>
                Apply Filters
            </button>
            
            <a href="{{ route('admin.system-feedbacks.index') }}" class="filter-btn reset-btn">
                <i class="fas fa-times"></i>
                Reset
            </a>
        </div>
    </form>
    
    <!-- Active Filters Display -->
    @if(request()->hasAny(['filter', 'status', 'type', 'rating']) && 
        (request('filter') != 'all' || request('status') != 'all' || request('type') != 'all' || request('rating') != 'all'))
        <div class="active-filters">
            <span class="active-filters-label">Active Filters:</span>
            <div class="filter-tags">
                @if(request('filter') && request('filter') != 'all')
                    <span class="filter-tag">
                        Source: {{ ucfirst(request('filter')) }}
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}" class="remove-filter">×</a>
                    </span>
                @endif
                
                @if(request('status') && request('status') != 'all')
                    <span class="filter-tag">
                        Status: {{ ucfirst(request('status')) }}
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="remove-filter">×</a>
                    </span>
                @endif
                
                @if(request('type') && request('type') != 'all')
                    <span class="filter-tag">
                        Type: {{ str_replace('_', ' ', ucfirst(request('type'))) }}
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'all']) }}" class="remove-filter">×</a>
                    </span>
                @endif
                
                @if(request('rating') && request('rating') != 'all')
                    <span class="filter-tag">
                        Rating: {{ request('rating') }} Star{{ request('rating') > 1 ? 's' : '' }}
                        <a href="{{ request()->fullUrlWithQuery(['rating' => 'all']) }}" class="remove-filter">×</a>
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>
<!-- Feedbacks List -->
<div class="feedbacks-section">
    @if($feedbacks->count() > 0)
        <div class="feedbacks-list">
            @foreach($feedbacks as $feedback)
                @php
                    $userInfo = $feedback->getUserInfo();
                @endphp
                <div class="feedback-card {{ $userInfo['is_government'] ? 'government-feedback' : 'citizen-feedback' }}">
                    <div class="feedback-header">
                        <div class="feedback-info">
                            <h3>{{ $feedback->title ?? 'Feedback #' . $feedback->id }}</h3>
                            <div class="feedback-meta">
                                <span class="author {{ $userInfo['is_government'] ? 'government' : 'citizen' }}">
                                    <i class="fas {{ $userInfo['is_government'] ? 'fa-user-shield' : 'fa-user' }}"></i>
                                    {{ $userInfo['username'] }} 
                                    ({{ ucfirst($userInfo['usertype']) }})
                                </span>
                                <span class="rating">
                                    <i class="fas fa-star"></i>
                                    {{ $feedback->rating }}/5 stars
                                </span>
                                <span class="date">
                                    <i class="fas fa-calendar"></i>
                                    {{ $feedback->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="feedback-badges">
                            @if($feedback->type)
                                <span class="type-badge {{ $feedback->type }}">
                                    {{ str_replace('_', ' ', ucfirst($feedback->type)) }}
                                </span>
                            @endif
                            @if($feedback->priority)
                                <span class="priority-badge {{ $feedback->priority }}">
                                    {{ ucfirst($feedback->priority) }}
                                </span>
                            @endif
                            @if($feedback->status)
                                <span class="status-badge {{ $feedback->status }}">
                                    {{ ucfirst($feedback->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="feedback-content">
                        <p>{{ $feedback->feedback }}</p>
                    </div>
                    
                    @if($feedback->status)
                        <div class="feedback-actions">
                            <form method="POST" action="{{ route('admin.system-feedbacks.update-status', $feedback) }}" class="status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()">
                                    <option value="pending" {{ $feedback->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $feedback->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="resolved" {{ $feedback->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $feedbacks->appends(request()->query())->links() }}
        </div>
    @else
        <div class="no-feedbacks">
            <i class="fas fa-inbox"></i>
            <h3>No feedbacks found</h3>
            <p>No feedbacks match your current filters.</p>
        </div>
    @endif
</div>
</body>
</html>        
