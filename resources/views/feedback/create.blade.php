
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Submit Feedback</h2>
    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Your Name</label>
            <input type="text" name="username" id="username" class="form-control" required value="{{ old('username') }}">
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection