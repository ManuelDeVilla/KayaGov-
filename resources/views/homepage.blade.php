<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/homepage.css')
    @vite('resources/css/header.css')
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.navbar')
    </header>
    
    <div class="body">
        <section class="search-section">
            <div class="search-wrapper">
                <i class="fas fa-search icon"></i>
                <input type="text" placeholder="Search your Concerns...">
            </div>

            <div class="filter-wrapper">
                <button class="filter"><i class="fa-solid fa-filter"></i>Filter</button>

                <div id="option-wrapper" class="option-wrapper">
                    <div class="option-header">
                        <p>Filter and Sort</p>
                        <button>Clear All</button>
                    </div>

                    <div class="applied-filters">
                        <button><i class="fa-solid fa-xmark"></i><span class="text-content">Pending</span></button>
                        <button><i class="fa-solid fa-xmark"></i><span class="text-content">Laguna</span></button>
                        <button><i class="fa-solid fa-xmark"></i><span class="text-content">Santa Rosa</span></button>
                    </div>

                    <form action="">
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
                                    <input type="text" placeholder="Search Province...">
                                </div>
                                <i class="fa-solid fa-angle-up"></i>
                            </div>
                            <div id="province-options" class="province-options">
                                <p>asdasd</p>
                                <p>asdasd</p>
                                <p>asdasd</p>
                                <p>asdasd</p>
                                <p>asdasd</p>
                                <p>asdasd</p>
                            </div>
                        </div>

                        <div id="city" class="city">
                            <div class="city-header">
                                <p>City</p>
                                <div id="city-searchbar" class="sort-search sort-city">
                                    <i class="fas fa-search icon"></i>
                                    <input type="text" placeholder="Search City...">
                                </div>
                                <i class="fa-solid fa-angle-up"></i>
                            </div>

                            <div id="city-options" class="city-options">
                                <p>asdasd</p>
                                <p>asdasd</p>
                                <p>asdasd</p>
                                <p>asdasd</p>
                                <p>asdasd</p>
                                <p>asdasd</p>
                            </div>
                        </div>

                        <div class="submit">
                            <button>Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="list-section">

            <div class="card">
                <div class="card-header">
                    <p class="header">May Nigga sa Kanto</p>
                    <div class="status progress">
                        <p class="progress"><span class="icon progress"><i class="fa-solid fa-circle-exclamation"></i></span>In Progress</p>
                    </div>
                </div>
                
                <div class="details">
                    <div class="category-wrapper progress">
                        <p class="progress"><span class="icon progress"><i class="fa-regular fa-map"></i></span>Roads</p>
                    </div>

                    <div class="location-wrapper">
                        <p class="location"><span class="icon location"><i class="fa-solid fa-location-dot"></i></span>Santa Rosa, Laguna</p>
                    </div>
                </div>

                <div class="description">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque quisquam nobis fugit expedita sit minima, cumque corrupti, itaque molestias atque quo. Eum, aliquam quis possimus ducimus autem accusamus iste similique! Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque quisquam nobis fugit expedita sit minima, cumque corrupti, itaque molestias atque quo. Eum, aliquam quis possimus ducimus autem accusamus iste similique!</p>
                </div>

                <div class="card-footer">
                    <div class="date">
                        <p><span class="icon"><i class="fa-regular fa-clock"></i></span>May 12, 2003</p>
                    </div>

                    <div class="priority">
                        <button><i class="fa-solid fa-arrow-up"></i></button>
                        <span>12ss</span>
                    </div>

                    <div class="share">
                        <button><i class="fa-solid fa-retweet"></i></button>
                        <span>12ss</span>
                    </div>

                    <div class="view">
                        <a href="">View Details <i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <p class="header">May Nigga sa Kanto</p>
                    <div class="status progress">
                        <p class="progress"><span class="icon progress"><i class="fa-solid fa-circle-exclamation"></i></span>In Progress</p>
                    </div>
                </div>
                
                <div class="details">
                    <div class="category-wrapper progress">
                        <p class="progress"><span class="icon progress"><i class="fa-regular fa-map"></i></span>Roads</p>
                    </div>

                    <div class="location-wrapper">
                        <p class="location"><span class="icon location"><i class="fa-solid fa-location-dot"></i></span>Santa Rosa, Laguna</p>
                    </div>
                </div>

                <div class="description">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque quisquam nobis fugit expedita sit minima, cumque corrupti, itaque molestias atque quo. Eum, aliquam quis possimus ducimus autem accusamus iste similique! Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque quisquam nobis fugit expedita sit minima, cumque corrupti, itaque molestias atque quo. Eum, aliquam quis possimus ducimus autem accusamus iste similique!</p>
                </div>

                <div class="card-footer">
                    <div class="date">
                        <p><span class="icon"><i class="fa-regular fa-clock"></i></span>May 12, 2003</p>
                    </div>

                    <div class="priority">
                        <button><i class="fa-solid fa-arrow-up"></i></button>
                        <span>12ss</span>
                    </div>

                    <div class="share">
                        <button><i class="fa-solid fa-retweet"></i></button>
                        <span>12ss</span>
                    </div>

                    <div class="view">
                        <a href="">View Details <i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <p class="header">May Nigga sa Kanto</p>
                    <div class="status progress">
                        <p class="progress"><span class="icon progress"><i class="fa-solid fa-circle-exclamation"></i></span>In Progress</p>
                    </div>
                </div>
                
                <div class="details">
                    <div class="category-wrapper progress">
                        <p class="progress"><span class="icon progress"><i class="fa-regular fa-map"></i></span>Roads</p>
                    </div>

                    <div class="location-wrapper">
                        <p class="location"><span class="icon location"><i class="fa-solid fa-location-dot"></i></span>Santa Rosa, Laguna</p>
                    </div>
                </div>

                <div class="description">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque quisquam nobis fugit expedita sit minima, cumque corrupti, itaque molestias atque quo. Eum, aliquam quis possimus ducimus autem accusamus iste similique! Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque quisquam nobis fugit expedita sit minima, cumque corrupti, itaque molestias atque quo. Eum, aliquam quis possimus ducimus autem accusamus iste similique!</p>
                </div>

                <div class="card-footer">
                    <div class="date">
                        <p><span class="icon"><i class="fa-regular fa-clock"></i></span>May 12, 2003</p>
                    </div>

                    <div class="priority">
                        <button><i class="fa-solid fa-arrow-up"></i></button>
                        <span>12ss</span>
                    </div>

                    <div class="share">
                        <button><i class="fa-solid fa-retweet"></i></button>
                        <span>12ss</span>
                    </div>

                    <div class="view">
                        <a href="">View Details <i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Tester if user is logged in or out -->
    @auth
        <h1>Logged In</h1>
    @endauth

    @vite('resources/js/homepage/filter.js')
</body>
</html>