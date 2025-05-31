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
    @include('includes.sidebar')
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
                
                <!-- Details Panel -->
                <div class="details-panel">
                    <h2 class="details-header">Details</h2>
                    
                    <div class="details-content">
                        <div class="details-item">
                            <span class="details-label">Reported by</span>
                            <span class="details-value">Manuel De Vera</span>
                        </div>
                        
                        <div class="details-item">
                            <span class="details-label">Department</span>
                            <span class="details-value">Roads</span>
                        </div>
                        
                        <div class="details-item">
                            <span class="details-label">Submitted on</span>
                            <span class="details-value">May 1, 2023</span>
                        </div>
                        
                        <div class="details-item">
                            <span class="details-label">Last Updated</span>
                            <span class="details-value">May 5, 2023</span>
                        </div>
                        
                        <div class="details-item">
                            <span class="details-label">Status</span>
                            <span class="details-value">
                                <span class="status-badge in-progress">In Progress</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>