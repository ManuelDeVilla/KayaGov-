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
        <form action="{{ route('concerns.comment', $concerns->id) }}" method="POST">
            @csrf
            <input type="hidden" name="concern_id" value="{{ $concern->id ?? 1 }}">
            <div class="comment-input-container">
                <input 
                    type="text" 
                    name="comment" 
                    class="comment-input" 
                    placeholder="Add your comment..."
                >
                <button type="submit" class="comment-submit">Send</button>
            </div>
        </form>
    </div>
</div>