<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/feedback-form.css">
</head>
<body>
    <div class="container feedback-form-container">
        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom:12px;">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom:12px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h2 class="feedback-title">Submit Feedback</h2>
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Your Name</label>
                <div class="profile-name-box">
                    <i class="fas fa-user-circle"></i>
                    <span class="profile-name">{{ Auth::user()->username ?? 'Unknown User' }}</span>
                </div>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="">Select type</option>
                    <option value="bug_report" {{ old('type') == 'bug_report' ? 'selected' : '' }}>Bug Report</option>
                    <option value="feature_request" {{ old('type') == 'feature_request' ? 'selected' : '' }}>Feature Request</option>
                    <option value="general_feedback" {{ old('type') == 'general_feedback' ? 'selected' : '' }}>General Feedback</option>
                    <option value="complaint" {{ old('type') == 'complaint' ? 'selected' : '' }}>Complaint</option>
                </select>
            </div>
            <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" placeholder="Provide appropriate title for your feedback" name="title" id="title" class="form-control" required value="{{ old('title') }}">
        </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5)</label>
                <div class="rating-radio-group">
                    @for($i=1; $i<=5; $i++)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label class="form-check-label" for="rating{{ $i }}">{{ $i }}</label>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="mb-3">
                <label for="feedback" class="form-label">Your Feedback</label>
                <textarea name="feedback" id="feedback" class="form-control" rows="5" required>{{ old('feedback') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select name="priority" id="priority" class="form-control">
                    <option value="">Select priority (optional)</option>
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            <input type="hidden" name="status" value="pending">
            <input type="hidden" name="usertype" value="{{ Auth::user()->usertype ?? 'citizen' }}">
            <div class="feedback-actions">
                <button type="submit" class="btn btn-primary feedback-submit-btn">
                    <i class="fas fa-paper-plane"></i> Submit
                </button>
                <button type="button" class="btn btn-secondary feedback-cancel-btn" onclick="window.history.back()">
                    <i class="fas fa-arrow-left"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</body>
</html>
