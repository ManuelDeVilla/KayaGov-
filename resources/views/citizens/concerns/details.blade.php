<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @extends('layouts.app')
    @vite('resources/css/homepage.css')
    @vite('resources/css/header.css')
    @vite('resources/css/citizens/sidebar-styles.css')
    @vite('resources/css/citizens/concern-details.css')
</head>
<body>
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
                        <div class="concern-card">
                            <div class="concern-header">
                                <div class="concern-status">
                                    <span class="status-badge in-progress">In Progress</span>
                                    <span class="status-badge roads">Roads</span>
                                    <span class="date-submitted">May 1, 2023</span>
                                </div>
                                <h1 class="concern-title">Dangerous bump hole in road</h1>
                                <p class="concern-description">
                                    Hi I'd like to report a hazardous bump on San Isidro, Cabuyao that's been causing sudden jolts, vehicle damage and posing a serious safety risk to passing motorists.
                                </p>
                                <div class="concern-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>San Isidro, Cabuyao</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comments Section -->
                        <div class="comments-section">
                            <h3 class="comments-header">Comments (1)</h3>
                            
                            <div class="comment">
                                <div class="comment-user">
                                    <div class="user-avatar">
                                        <div class="avatar-initial">A</div>
                                    </div>
                                    <div class="user-info">
                                        <span class="user-name">Anna Lou Reyes</span>
                                        <span class="comment-date">May 5, 2023</span>
                                    </div>
                                </div>
                                <p class="comment-text">I've seen this bump too, please fix this urgent.</p>
                            </div>
                            
                            <div class="add-comment">
                                <div class="comment-input-container">
                                    <input type="text" class="comment-input" placeholder="Add your comment...">
                                    <button class="comment-submit">Send</button>
                                </div>
                            </div>
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