
@vite([
    'resources/css/concerns.css', 
    'resources/css/header.css', 
    'resources/css/citizens/sidebar-styles.css',
    'resources/css/search-filter.css'
])
<div class="search-wrapper">
    <i class="fas fa-search icon"></i>
    <input type="text" placeholder="Search your Concerns..." name="search" value="{{ request('search') }}">
</div>

<div class="filter-wrapper">
    <button class="filter">
        <i class="fa-solid fa-filter"></i>Filter
    </button>

    <div id="option-wrapper" class="option-wrapper">
        <div class="option-header">
            <p>Filter and Sort</p>
            <button type="button" class="clear-filters">Clear All</button>
        </div>

        <form action="{{ route('search.concerns') }}" method="GET">
            <!-- Status Filters -->
            <div id="sort-by" class="sort-by">
                <div class="sort-by-header">
                    <p>Status</p>
                    <i class="fa-solid fa-angle-up"></i>
                </div>
                @foreach(['Pending', 'In Progress', 'Resolved'] as $status)
                    <div class="status-option">
                        <label>
                            <input type="checkbox" name="status[]" value="{{ $status }}"
                                {{ in_array($status, request('status', [])) ? 'checked' : '' }}>
                            {{ $status }}
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Province Filter -->
            <div class="province">
                <div class="province-header">
                    <p>Province</p>
                    <div class="sort-search sort-province">
                        <i class="fas fa-search icon"></i>
                        <input type="text" placeholder="Search Province...">
                    </div>
                </div>
                <div class="province-options">
                    @foreach($provinces as $province)
                        <label>
                            <input type="checkbox" name="province[]" value="{{ $province->id }}"
                                {{ in_array($province->id, request('province', [])) ? 'checked' : '' }}>
                            {{ $province->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="submit">
                <button type="submit">Apply Filters</button>
            </div>
        </form>
    </div>
</div>