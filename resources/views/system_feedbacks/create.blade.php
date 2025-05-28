@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Submit System Feedback</h2>
    <form action="{{ route('system-feedbacks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Your Name</label>
            <input type="text" name="username" id="username" class="form-control" required value="{{ old('username', Auth::user()->name ?? '') }}">
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
            <label for="rating" class="form-label">Rating (1-5)</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">Select rating</option>
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
