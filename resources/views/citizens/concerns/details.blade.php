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
    @vite('resources/js/carousel.js')
    
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
                                    <span class="status-badge {{ $concerns->status == 'in progress' ? 'in-progress' : $concerns->status }}">{{ $concerns->status }}</span>
                                    <span class="status-badge roads">{{ $concerns->category }}</span>
                                    <span class="date-submitted">{{ $concerns->created_at->format('M d, Y') }}</span>
                                <div class="concern-actions">
                                    @if(Auth::user()->usertype == 'staff')
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
                                    @elseif (Auth::user()->usertype == 'admin')
                                        <form action="{{ route('concerns.delete', $concerns->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="action-btn accept">Delete</button>
                                        </form>
                                    @endif
                                </div>
                                    
                                </div>
                                <h1 class="concern-title">{{ $concerns->title }}</h1>
                                @if($image_count > 0)
                                        <div class="carousel-container">
                                            <div class="carousel-track" id="carouselTrack">
                                                @foreach($concerns->concern_images as $image)
                                                    <div class="carousel-slide">
                                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Concern Image" style="width: 100%; max-height: 300px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if ($image_count > 1)
                                                <div class="carousel-controls">
                                                <button onclick="moveSlide(-1)" class="carousel-arrow left">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </button>
                                                    <button onclick="moveSlide(1)" class="carousel-arrow right">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
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

                            @foreach ($concerns->comments->whereNull('parent_id') as $comment)
                                <div class="comment">
                                    <div class="comment-user">
                                        <img src="{{ $comment->user->image_path }}" class="user-avatar" alt="{{ Auth::user()->username }}'s avatar">

                                        <div class="user-info">
                                            <span class="comment-user-name">{{ $comment->user->username }}</span>
                                            <span class="comment-date">{{ $comment->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    <p class="comment-text">{{ $comment->comment }}</p>

                                    <!-- Nested Replies -->
                                    @if($comment->replies->count())
                                        <div class="comment-replies hidden">
                                            @foreach ($comment->replies as $reply)
                                                <div class="comment">
                                                    <div class="comment-user">
                                                        <img src="{{ $reply->user->image_path }}" class="user-avatar" alt="{{ $reply->user->username }}'s avatar">

                                                        <div class="user-info">
                                                            <span class="reply-user-name">{{ $reply->user->username }}</span>
                                                            <span class="comment-date">{{ $reply->created_at->format('M d, Y') }}</span>
                                                        </div>
                                                    </div>
                                                    <p class="comment-text">{{ $reply->comment }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Reply button -->
                                    @if (auth()->check())
                                        <div class="reply-footer">
                                            <div class="reply-interaction-container">
                                                <button class="reply-toggle" data-comment-id="{{ $comment->id }}">Reply</button>
                                                <button class="see-reply {{ !$comment->replies->count() > 0 ? 'hidden' : '' }}">See replies</button>
                                            </div>

                                            <div class="reply-form-container hidden">
                                                <form
                                                    action="{{ route('concerns.comments.store', $concerns->id) }}"
                                                    class="reply-form"
                                                    method="POST"
                                                >
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    <div class="comment-input-container">
                                                        <input type="text" class="comment-input" name="comment" placeholder="Add comment..." required>
                                                        <button type="submit" class="comment-submit">></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <!-- Add New Comment -->
                            @if (auth()->check())
                                <form action="{{ route('concerns.comments.store', $concerns->id) }}" method="POST">
                                    @csrf
                                    <div class="comment-input-container">
                                    <input type="text" class="comment-input" name="comment" required placeholder="Add your comment...">
                                    <button type="submit" class="comment-submit">Add Comment</button>
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

@vite('resources/js/details/reply.js')
</html>