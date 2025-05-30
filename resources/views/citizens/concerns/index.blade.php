<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concerns</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite(['resources/css/concerns.css', 'resources/css/header.css', 'resources/css/citizens/sidebar-styles.css'])
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.sidebar')
    </header>

    <div class="body">
        <!-- Search & Filter Section -->
        <section class="search-section">
            @include('citizens.concerns.partials.search-filter')
        </section>
           
        <!-- Concerns List Section -->
        <section class="list-section">
            @forelse($concerns as $concern)
                <div class="card">
                    <div class="card-header">
                        <p class="header">{{ $concern->title }}</p>
                        <div class="status {{ strtolower($concern->status) }}">
                            <p class="{{ strtolower($concern->status) }}">
                                <span class="icon {{ strtolower($concern->status) }}">
                                    @if($concern->status == 'Pending')
                                        <i class="fa-solid fa-clock"></i>
                                    @elseif($concern->status == 'In Progress')
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                    @else
                                        <i class="fa-solid fa-check"></i>
                                    @endif
                                </span>
                                {{ $concern->status }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="details">
                        <div class="category-wrapper {{ strtolower($concern->status) }}">
                            <p class="{{ strtolower($concern->status) }}">
                                <span class="icon {{ strtolower($concern->status) }}">
                                    <i class="fa-regular fa-map"></i>
                                </span>
                                {{ $concern->category }}
                            </p>
                        </div>

                        <div class="location-wrapper">
                            <p class="location">
                                <span class="icon location">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>
                                {{ $concern->cities }}
                            </p>
                        </div>
                    </div>

                    <div class="description">
                        <p>{{ Str::limit($concern->description, 200) }}</p>
                    </div>

                    <div class="card-footer">
                        <div class="date">
                            <p>
                                <span class="icon">
                                    <i class="fa-regular fa-clock"></i>
                                </span>
                                {{ $concern->created_at->format('M d, Y') }}
                            </p>
                        </div>

                        <div class="priority">
                            <button><i class="fa-solid fa-arrow-up"></i></button>
                            <span>{{ $concern->priority }}</span>
                        </div>

                        <div class="share">
                            <button><i class="fa-solid fa-retweet"></i></button>
                            <span>{{ $concern->shares_count ?? 0 }}</span>
                        </div>

                        <div class="view">
                            <a href="{{ route('citizens.concerns.details', $concern->id) }}">
                                View Details <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-concerns">
                    <p>No concerns found</p>
                </div>
            @endforelse
        </section>
    </div>

    @vite('resources/js/homepage/filter.js')
</body>
</html>