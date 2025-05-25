
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KayaGov</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('includes.header')
    @include('includes.navbar')

    <div class="py-4">
        @yield('content')
    </div>

    <div class="app-container">
        @include('includes.sidebar')
        
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>