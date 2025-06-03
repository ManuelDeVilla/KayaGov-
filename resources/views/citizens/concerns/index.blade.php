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
    @vite('resources/css/citizens/sidebar-styles.css')
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.sidebar')
    </header>
    <div class="body">
        <div class="body-header">
            @auth
                <h1>Welcome, {{ Auth::user()->username }}</h1>
            @endauth

            @guest
                <h1>KayaGov? Concerns</h1>
            @endguest
            <p>Scroll and explore all the reported concerns.</p>
        </div>

        <section class="search-section">
            <div class="search-wrapper">
                <i class="fas fa-search icon"></i>
                <input type="text" id="search-concern" placeholder="Search your Concerns...">
            </div>

            <div class="filter-wrapper">
                <button class="filter"><i class="fa-solid fa-filter"></i>Filter</button>

                <div id="option-wrapper" class="option-wrapper">
                    <div class="option-header">
                        <p>Filter and Sort</p>
                        <button id="clear-all">Clear All</button>
                    </div>

                    <div class="applied-filters">
                        <button id="applied_status" class="applied-filters-status"><i class="fa-solid fa-xmark"></i><span id="apply_text_status" class="text-content"></span></button>

                        <button id="applied_province" class="applied-filters-province"><i class="fa-solid fa-xmark"></i><span class="text-content"  id="apply_text_province"></span></button>

                        <button id="applied_city" class="applied-filters-city"><i class="fa-solid fa-xmark"></i><span class="text-content"  id="apply_text_city"></span></button>
                    </div>

                <div id="sort-by" class="sort-by">
                        <div id="sort-header" class="sort-by-header">
                            <p>Sort By</p>
                            <i class="fa-solid fa-angle-up"></i>
                        </div>
                        <div id="pending" class="pending">
                            <p>Pending</p>
                            <i id="pending-icon" class="fa-regular fa-square"></i>
                        </div>
                        <div id="in_progress" class="in-progress">
                            <p>In Progress</p>
                            <i id="in-progress-icon" class="fa-regular fa-square"></i>
                        </div>
                        <div id="resolved" class="resolved">
                            <p>Resolved</p>
                            <i id="resolved-icon" class="fa-regular fa-square"></i>
                        </div>
                    </div>

                    <div id="province" class="province">
                        <div class="province-header">
                            <p>Province</p>
                            <div id="province-searchbar" class="sort-search sort-province">
                                <i class="fas fa-search icon"></i>
                                <input type="text" id="search-province" placeholder="Search Province...">
                            </div>
                            <i class="fa-solid fa-angle-up"></i>
                        </div>
                        <div id="province-options" class="province-options">
                        </div>
                    </div>

                    <div id="city" class="city">
                        <div class="city-header">
                            <p>City</p>
                            <div id="city-searchbar" class="sort-search sort-city">
                                <i class="fas fa-search icon"></i>
                                <input type="text" id="search-city" placeholder="Search City...">
                            </div>
                            <i class="fa-solid fa-angle-up"></i>
                        </div>

                        <div id="city-options" class="city-options">
                        </div>
                    </div>

                    <div class="submit">
                        <button id="submit-filter">Apply Filters</button>
                    </div>
                </div>
            </div>
        </section>
           
        <section class="list-section">
            @foreach ($concerns as $concern)
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
                            <span>{{ $concern->priority }}</span>
                        </div>

                        <div class="share">
                            <button><i class="fa-solid fa-retweet"></i> <span>share</span></button>
                        </div>

                        <div class="view">
                            <a href="{{ route('citizens.concerns.details', $concern->id) }}">View Details <i class="fa-solid fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </div>

    <!-- Tester if user is logged in or out -->
    @auth
        <h1>Logged In</h1>
        <p>{{ Auth::user()->city }}</p>
    @endauth

    <script>
        const search_concerns = "{{ route('search.concerns') }}"
        const show_concerns = "{{ route('concern-list') }}"
        const sort_concerns = "{{ route('sort.concerns') }}"
        const list_province = "{{ route('list.province') }}"
        const list_search_province = "{{ route('list.search-province') }}"
        const list_city = "{{ route('show.create-concern') }}"
        const list_search_city = "{{ route('search.create-concern') }}"
    </script>
    @vite('resources/js/homepage/filter.js')
</body>
</html>