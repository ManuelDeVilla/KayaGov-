<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/dashboard.css')
    @vite('resources/css/header.css')
    @vite('resources/css/citizens/sidebar-styles.css')
    @vite('resources/js/sidebar.js')
    @vite('resources/css/citizens/concern-details.css')
    
</head>
<body>
    @include('includes.header')

    @if(Auth::user()->usertype == 'staff')
        @include('includes.staff-sidebar')
    @elseif (Auth::user()->usertype == 'admin')
        @include('includes.admin-sidebar')
    @else
        @include('includes.sidebar')    
    @endif
<div class="app-container">
        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                <div class="content-container">
                    <div class="back-link">
                        <a href="/">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                    
                    <div class="concern-container">
                        @if($concerns)
                        <div class="concern-card">
                            <div class="concern-header">
                                <div class="concern-status">
                                    <span class="status-badge in-progress">{{ $concerns->status }}</span>
                                    <span class="status-badge roads">{{ $concerns->category }}</span>
                                    <span class="date-submitted">{{ $concerns->created_at->format('M d, Y') }}</span>
                                    @if(Auth::user()->usertype == 'staff')
                                <div class="concern-actions">
                                    @if($concerns->status === 'pending')
                                        <form action="{{ route('concerns.updateStatus', $concerns->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="in progress">
                                            <button type="submit" class="action-btn accept">Accept</button>
                                        </form>

                                        <form action="{{ route('concerns.updateStatus', $concerns->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="action-btn resolve">Reject</button>
                                        </form>
                                    @elseif($concerns->status === 'in progress')
                                        <!-- Resolved Button -->
                                        <form action="{{ route('concerns.updateStatus', $concerns->id) }}" method="POST" style="display: inline; margin-left: 10px;">
                                            @csrf
                                            <input type="hidden" name="status" value="resolved">
                                            <button type="submit" class="action-btn resolve">Resolved</button>
                                        </form>

                                        <!-- Cancel Button (Optional, if you still want it) -->
                                        <form action="{{ route('concerns.updateStatus', $concerns->id) }}" method="POST" style="display: inline; margin-left: 10px;">
                                            @csrf
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="action-btn cancel">Cancel</button>
                                        </form>

                                    @elseif($concerns->status === 'rejected')
                                        <span class="status-label rejected">Rejected</span>
                                    @endif
                                </div>

                                    @endif
                                </div>
                                <h1 class="concern-title">{{ $concerns->title }}</h1>
                                <p class="concern-description">
                                    {{ $concerns->description }}
                                </p>
                                <div class="concern-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $concerns->city->city }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- Comments Section -->   
                       <div class="comments-section">
                            <h3 class="comments-header">
                                Comments ({{ $concerns->comments->count() }})
                            </h3>   

                            @foreach ($concerns->comments as $comment)
                                {{ $comment->user->username}}
                                <div class="comment">
                                    <div class="comment-user">
                                        <div class="user-avatar">
                                            <div class="avatar-initial">
                                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="user-info">
                                            <span class="user-name">{{ $comment->user->name }}</span>
                                            <span class="comment-date">{{ $comment->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    <p class="comment-text">{{ $comment->comment }}</p>
                                </div>
                            @endforeach

                            <!-- Add New Comment -->
                            @if (auth()->check())
                                <form action="{{ route('concerns.comments.store', $concerns->id) }}" method="POST">
                                    @csrf
                                    <div class="comment-input-container">
                                    <input type="text" class="comment-input" name="comment" required placeholder="Add your comment...">
                                    <button class="comment-submit">Add Comment</button>
                                    </div>
                                </form>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>