<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/homepage.css')
    @vite('resources/css/header.css')

    @if(Auth::user()->usertype == 'staff')
        @vite('resources/css/staff/staff-sidebar.css')

    @elseif (Auth::user()->usertype == 'admin')
        @vite('resources/css/admin/admin-sidebar.css')
    @else
        @vite('resources/css/citizens/sidebar-styles.css')
    @endif

    @vite('resources/css/citizens/sidebar-styles.css')
</head>
<body>
    <header>
        @include('includes.header')

        @if(Auth::user()->usertype == 'staff')
            @include('includes.staff-sidebar')
        @elseif (Auth::user()->usertype == 'admin')
            @include('includes.admin-sidebar')
        @else
            @include('includes.sidebar')
        @endif
    </header>
    <div class="body">
        <div class="body-header">
            <h1>In Progress Concerns</h1>
            <p class="subtitle">Manage and respond to citizens' concerns</p>
        </div>
           
        <section class="list-section">
            @foreach($inProgressConcerns as $concern)
                <div class="card">
                    <div class="card-header">
                        <p class="header">{{ $concern->title }}</p>
                        <div class="status progress">
                            <p class="progress"><span class="icon progress"><i class="fa-solid fa-circle-exclamation"></i></span>{{ $concern->status }}</p>
                        </div>
                    </div>
                    
                    <div class="details">
                        <div class="category-wrapper progress">
                            <p class="progress"><span class="icon progress"><i class="fa-regular fa-map"></i></span>{{ $concern->category }}</p>
                        </div>

                        <div class="location-wrapper">
                            <p class="location"><span class="icon location"><i class="fa-solid fa-location-dot"></i></span>{{ $concern->city->city }}</p>
                        </div>
                    </div>

                    <div class="description">
                        <p>{{ $concern->description }}</p>
                    </div>

                    <div class="card-footer">
                        <div class="date">
                            <p><i class="fa-regular fa-clock"></i> {{ $concern->created_at->format('M d, Y') }}</p>
                        </div>

                        <div class="priority">
                            <button><i class="fa-solid fa-arrow-up"></i></button>
                            <span class="priority-text">{{ $concern->priority_count }}</span>

                            <span class="hidden" id={{ $concern->id }}></span>
                        </div>

                        <div class="share">
                            <button><i class="fa-solid fa-retweet"></i> <span>share</span></button>
                        </div>

                        <div class="view">
                            <a class="links" href="{{ route('citizens.concerns.details', $concern->id) }}">View Details <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        <div class="message">
            <span>Link Copied</span>
            <i class="fa-solid fa-xmark clickable"></i>
        </div>
    </div>

    <script>
        const search_concerns = "{{ route('search.concerns') }}"
        const show_concerns = "{{ route('concern-list') }}"
        const sort_concerns = "{{ route('sort.concerns') }}"
        const list_province = "{{ route('list.province') }}"
        const list_search_province = "{{ route('list.search-province') }}"
        const list_city = "{{ route('show.create-concern') }}"
        const list_search_city = "{{ route('search.create-concern') }}"
        const add_priority = "{{ route('add.priorities') }}"
        const user_id = parseInt("{{ Auth::user()->id }}")
    </script>
    @vite('resources/js/homepage/filter.js')
    <!-- For Prioritze and Share Button -->
    @vite('resources/js/homepage/functionality.js')
</body>
</html>