

@php
    // Fake user for testing
    $user = (object)[
        'username' => 'Anna',
        'usertype' => 'staff'
    ];
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Government Staff Dashboard</h2>
    <p>Welcome, {{ $user->username }}!</p>
    <!-- Add staff-specific content here -->
</div>
@endsection