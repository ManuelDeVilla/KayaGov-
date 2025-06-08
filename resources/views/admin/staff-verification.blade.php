<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KayaGov?</title>
    
    <!-- Meta tag for csrf for js -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/admin/staff-verification.css')
    @vite('resources/css/header.css')
    @vite('resources/css/admin/admin-sidebar.css')
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.admin-sidebar')
    </header>
    
    <div class="body">
        <section class="header">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="search-input" placeholder="Search Username...">
            </div>
        </section>

        <section class="user-wrapper">
            <div class="user-list">
                <div class="user-header">
                    <p>Staff Registered (<span>{{ $count_verify }}</span>)</p>
                </div>

                <div class="user-content">
                    
                </div>
            </div>
        </section>
    </div>

    <script>
        const get_verification = "{{ route('list.staff-verification') }}"
        const submit_form = "{{ route('submit.verification') }}"
    </script>

    @vite('resources/js/verification.js')
</body>
</html>