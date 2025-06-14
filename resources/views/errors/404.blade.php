<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Fallback Page</title>
    @vite(['resources/css/fallback.css'])
</head>
<body>
    <div class="image">
        <img src="{{ asset('images/fallback.png') }}" alt="Page Not Found" style="width: 35%; height: 35%; display: block; margin: 0 auto; margin-top: 20px;">
        <h1 class="text-center">Page Not Found</h1>
        <p class="text-center">The page you are looking for does not exist.</p>
        <p class="text-center"><a href="{{ route('dashboard') }}">Go to Homepage</a></p>
    </div>
</body>
</html>