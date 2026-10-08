// Get Filter button
const filter_button = document.querySelector('.filter')

// Get Filter div
const filter_div = document.querySelector('#option-wrapper')

// Filter Apply Button
const apply_filter = document.querySelector('#submit-filter')

// Get List Section Divs for each card
const list_section = document.querySelector('.list-section')
const search_input = document.querySelector('#search-concern')

// Applied Filters
const apply_status = document.querySelector('#applied_status')
const apply_text_status = document.querySelector('#apply_text_status')

const apply_province = document.querySelector('#applied_province')
const apply_text_province = document.querySelector('#apply_text_province')

const apply_city = document.querySelector('#applied_city')
const apply_text_city = document.querySelector('#apply_text_city')

filter_div.addEventListener('click', function (event) {
    event.stopPropagation()
})

// For toggling sort by
const sort_by = document.querySelector('#sort-by')
const pending = document.querySelector('#pending')
const in_progress = document.querySelector('#in_progress')
const resolved = document.querySelector('#resolved')
const prioritize = document.querySelector('#prioritize')

// Clear All Sorts button
const clear_button = document.querySelector('#clear-all')

// Sort Object
const sort_temp = {
    status: {
        pending: false,
        in_progress: false,
        resolved: false,
        prioritize: false
    },
    city: null,
    province: null
}

const sort_temp_names = {
    city: null,
    province: null
}

const sort = {
    status: {
        pending: false,
        in_progress: false,
        resolved: false,
        prioritize: false
    },
    city: null,
    province: null
}

const sort_names = {
    city: null,
    province: null
}

// Checks if one of the value is truthful
function sortChecker () {
    // Checks if status has true value
    const has_true_status = Object.values(sort.status).some(status => status == true)

    // Checks if province is not null
    const has_province = (sort.province != null)

    // Checks if city is not null
    const has_city = (sort.city != null)

    // If one is truthful, then return true
    if (has_true_status || has_province || has_city) {
        return true

        // Else if none is truthful return false
    } else {
        return false
    }
}

// Display filter div
filter_button.addEventListener('click', function (event) {
    // Stops event listener of the parent
    event.stopPropagation()
    filter_div.classList.add('active')
    console.log(sort)

    // Applied status
    for (const [keys, values] of Object.entries(sort.status)) {
        // If there is a true value show the apply_status div
        if (values) {
            // If it does not have an active in classlist add one and change the text content to the status that is true
            apply_status.classList.add('active')
            apply_text_status.textContent = keys
            break

            // If there is no true value do not show the apply_status div
        } else {
            apply_status.classList.remove('active')
            apply_text_status.textContent = ''
        }
    }

    // Applied Province
    // If not null then show apply_province div and its text content set to the value of sort.province
    if (sort.province != null) {
        if (!apply_province.classList.contains('active')) {
            apply_province.classList.add('active')
        }
        apply_text_province.textContent = sort_names.province

        // Else if null then do not show the apply_province div
    } else {
        apply_province.classList.remove('active')
        apply_text_province.textContent = ''
    }

    // Applied City
    // If not null then show apply_city div and its text content set to the value of sort.city
    if (sort.city != null) {
        if (!apply_city.classList.contains('active')) {
            apply_city.classList.add('active')
        }
        apply_text_city.textContent = sort_names.city

        // Else if null then do not show the apply_city div
    } else {
        apply_city.classList.remove('active')
        apply_text_city.textContent = ''
    }
})

// For opening sort by div
sort_by.addEventListener('click', function () {
    pending?.classList.toggle('active')
    in_progress?.classList.toggle('active')
    resolved?.classList.toggle('active')
    prioritize?.classList.toggle('active')
})

// Toggling on each sort-by
const sort_children_div = sort_by.querySelectorAll('div')

const pending_icon = document.querySelector('#pending-icon')
const in_progress_icon = document.querySelector('#in-progress-icon')
const resolved_icon = document.querySelector('#resolved-icon')
const prioritize_icon = document.querySelector('#prioritize-icon')

sort_children_div.forEach((children_div) => {
    const id = children_div.id

    children_div.addEventListener('click', function (event) {
    
        switch (id) {
            case 'pending':
                event.stopPropagation()

                if (pending_icon.classList.contains('fa-square')) {
                    // If in-progress icon is checked uncheck it
                    if (in_progress_icon.classList.contains('fa-square-check')) {
                        in_progress_icon.classList.remove('fa-solid', 'fa-square-check')
                        in_progress_icon.classList.add('fa-regular', 'fa-square')

                        sort_temp.status.in_progress = false
                    }

                    // If resolved icon is checked uncheck it
                    if (resolved_icon.classList.contains('fa-square-check')) {
                        resolved_icon.classList.remove('fa-solid', 'fa-square-check')
                        resolved_icon.classList.add('fa-regular', 'fa-square')

                        sort_temp.status.resolved = false
                    }

                    // If prioritize icon is checked uncheck it
                    if (prioritize_icon.classList.contains('fa-square-check')) {
                        prioritize_icon.classList.remove('fa-solid', 'fa-square-check')
                        prioritize_icon.classList.add('fa-regular', 'fa-square')

                        sort_temp.status.prioritize = false
                    }

                    // Toggle Part
                    pending_icon.classList.remove('fa-regular', 'fa-square')
                    pending_icon.classList.add('fa-solid', 'fa-square-check')

                    sort_temp.status.pending = true

                    // Display Current Filters
                    apply_text_status.textContent = 'pending'
                    apply_status.classList.add('active')


                    // Toggle Part
                } else {
                    pending_icon.classList.remove('fa-solid', 'fa-square-check')
                    pending_icon.classList.add('fa-regular', 'fa-square')

                    // Remove current Filter
                    apply_status.classList.remove('active')

                    sort_temp.status.pending = false
                    sort.status.pending = false
                }
                break

            case 'in_progress':
                event.stopPropagation()

                if (in_progress_icon.classList.contains('fa-square')) {
                    // If pending icon is checked uncheck it
                    if (pending_icon.classList.contains('fa-square-check')) {
                        pending_icon.classList.remove('fa-solid', 'fa-square-check')
                        pending_icon.classList.add('fa-regular', 'fa-square')
                        
                        sort_temp.status.pending = false
                    }

                    // If resolved icon is checked uncheck it
                    if (resolved_icon.classList.contains('fa-square-check')) {
                        resolved_icon.classList.remove('fa-solid', 'fa-square-check')
                        resolved_icon.classList.add('fa-regular', 'fa-square')

                        sort_temp.status.resolved = false
                    }

                    // If prioritize icon is checked uncheck it
                    if (prioritize_icon.classList.contains('fa-square-check')) {
                        prioritize_icon.classList.remove('fa-solid', 'fa-square-check')
                        prioritize_icon.classList.add('fa-regular', 'fa-square')

                        sort_temp.status.prioritize = false
                    }

                    // Toggle Part
                    in_progress_icon.classList.remove('fa-regular', 'fa-square')
                    in_progress_icon.classList.add('fa-solid', 'fa-square-check')

                    sort_temp.status.in_progress = true

                    // Display Current Filters
                    apply_text_status.textContent = 'in-progress'
                    apply_status.classList.add('active')

                    // Toggle Part
                } else {
                    in_progress_icon.classList.remove('fa-solid', 'fa-square-check')
                    in_progress_icon.classList.add('fa-regular', 'fa-square')

                    // Remove current Filter
                    apply_status.classList.remove('active')

                    sort_temp.status.in_progress = false
                    sort.status.in_progress = false
                }
                break

            case 'resolved':
                event.stopPropagation()

                if (resolved_icon.classList.contains('fa-square')) {

                    // If in-progress icon is checked uncheck it
                    if (in_progress_icon.classList.contains('fa-square-check')) {
                        in_progress_icon.classList.remove('fa-solid', 'fa-square-check')
                        in_progress_icon.classList.add('fa-regular', 'fa-square')

                        sort_temp.status.in_progress = false
                    }

                    // If pending icon is checked uncheck it
                    if (pending_icon.classList.contains('fa-square-check')) {
                        pending_icon.classList.remove('fa-solid', 'fa-square-check')
                        pending_icon.classList.add('fa-regular', 'fa-square')

                        sort_temp.status.pending = false
                    }

                    // If prioritize icon is checked uncheck it
                    if (prioritize_icon.classList.contains('fa-square-check')) {
                        prioritize_icon.classList.remove('fa-solid', 'fa-square-check')
                        prioritize_icon.classList.add('fa-regular', 'fa-square')

                        sort_temp.status.prioritize = false
                    }

                    // Toggle Part
                    resolved_icon.classList.remove('fa-regular', 'fa-square')
                    resolved_icon.classList.add('fa-solid', 'fa-square-check')

                    sort_temp.status.resolved = true

                    // Display Current Filters
                    apply_text_status.textContent = 'resolved'
                    apply_status.classList.add('active')

                    // Toggle Part
                } else {
                    resolved_icon.classList.remove('fa-solid', 'fa-square-check')
                    resolved_icon.classList.add('fa-regular', 'fa-square')

                    // Remove current Filter
                    apply_status.classList.remove('active')

                    sort_temp.status.resolved = false
                    sort.status.resolved = false
                }
                break

                case 'prioritize':
                    event.stopPropagation()

                    if (prioritize_icon.classList.contains('fa-square')) {

                        // If in-progress icon is checked uncheck it
                        if (in_progress_icon?.classList?.contains('fa-square-check')) {
                            in_progress_icon?.classList?.remove('fa-solid', 'fa-square-check')
                            in_progress_icon?.classList?.add('fa-regular', 'fa-square')

                            sort_temp.status.in_progress = false
                        }

                        // If pending icon is checked uncheck it
                        if (pending_icon?.classList?.contains('fa-square-check')) {
                            pending_icon?.classList?.remove('fa-solid', 'fa-square-check')
                            pending_icon?.classList?.add('fa-regular', 'fa-square')

                            sort_temp.status.pending = false
                        }

                        // If resolved icon is checked uncheck it
                        if (resolved_icon?.classList?.contains('fa-square-check')) {
                            resolved_icon?.classList?.remove('fa-solid', 'fa-square-check')
                            resolved_icon?.classList?.add('fa-regular', 'fa-square')

                            sort_temp.status.resolved = false
                        }

                        // Toggle Part
                        prioritize_icon?.classList.remove('fa-regular', 'fa-square')
                        prioritize_icon?.classList.add('fa-solid', 'fa-square-check')

                        sort_temp.status.prioritize = true

                        // Display Current Filters
                        apply_text_status.textContent = 'prioritize'
                        apply_status.classList.add('active')

                        // Toggle Part
                    } else {
                        prioritize_icon.classList.remove('fa-solid', 'fa-square-check')
                        prioritize_icon.classList.add('fa-regular', 'fa-square')

                        // Remove current Filter
                        apply_status.classList.remove('active')

                        sort_temp.status.prioritize = false
                        sort.status.prioritize = false
                    }
                    break
        }
    })
})

// Toggling Province div
// Getting Elements
const province_div = document.querySelector('#province')
const province_searchbar = document.querySelector('#province-searchbar')
const province_options = document.querySelector('#province-options')
const province_search = document.querySelector('#search-province')

let latest_province_input = 0

// When province is click show province options & search div
// Checks first if province_div exists, to prevent interruptions
if (province_div) {
    province_div.addEventListener('click', function() {
        province_div.classList.toggle('active')
        province_searchbar.classList.toggle('active')
        province_options.classList.toggle('active')

        if (province_search.value.trim() != '') {
            province_search.value = ''
        }

        province_options.innerHTML = '<p class="loading-text">Loading...</p>'
        const current_province_input = ++latest_province_input;

        $.get(list_province, function (provinces) {
                if (current_province_input === latest_province_input) {
                    showProvince (provinces)
                }
            }
        )
    })
}

let search_timeout_id = null;

if (province_search) {
    province_search.addEventListener('input', function(event) {
        const search_input = event.target.value.trim()
        const current_province_input = ++latest_province_input

        province_options.innerHTML = '<p class="loading-text">Loading...</p>'

        const params = {search: search_input}
        clearTimeout(search_timeout_id);

        search_timeout_id = setTimeout(() => {
            $.get(list_search_province, params,
                function (provinces) {
                    if (current_province_input == latest_province_input) {
                        showProvince (provinces)
                        
                    }
                }
            )
        }, 300);
    })
}

// If the applied text changes, calls the showCity to only show the city of the selected province
apply_text_province?.addEventListener('textChange', function () {
    const selected_province = sort_temp.province

    if (city_options) {
        city_options.innerHTML = '<p class="loading-text">Loading...</p>'

        $.get(list_city,
            {province: selected_province},
            function (cities) {
                showCity (cities)
            }
        )
    }
})

function showProvince (provinces) {
    province_options.innerHTML = ''

    // Checks if prvoinces returns an array
    if (Array.isArray(provinces)) {
        provinces.forEach((province) => {
            const p_province = document.createElement('p')
            p_province.textContent = province.province
            province_options.appendChild(p_province)

            p_province.addEventListener('click', function () {
                apply_text_province.textContent = province.province

                apply_province.classList.add('active')
                sort_temp.province = province.id
                sort_temp_names.province = province.province
                apply_text_province.dispatchEvent(new Event('textChange'))
            })
        })

        // If it did not return as an array do not use for each
    } else {
        const p_province = document.createElement('p')
        p_province.textContent = provinces.province
        province_options.appendChild(p_province)

        p_province.addEventListener('click', function () {
            apply_text_province.textContent = provinces.province

            apply_province.classList.add('active')
            sort_temp.province = provinces.id
            sort_temp_names.province = provinces.province
            apply_text_province.dispatchEvent(new Event('textChange'))
        })
    }
}

// So that it would not close when clicking province searchbar
if (province_div) {
    province_searchbar.addEventListener('click', function (event) {
        event.stopPropagation()
    })
}

// Toggling City Divs
// Getting City Elements
const city_div = document.querySelector('#city')
const city_searchbar = document.querySelector('#city-searchbar')
const city_options = document.querySelector('#city-options')
const city_search = document.querySelector('#search-city')

let latest_city_input = 0

// When province is click show city options & search div
// Checks first if city_div exists, to prevent interruptions
if (city_div) {
    city_div.addEventListener('click', function() {
        city_div.classList.toggle('active')
        city_searchbar.classList.toggle('active')
        city_options.classList.toggle('active')

        if (city_search.value.trim() != '') {
            city_search.value = ''
        }

        city_options.innerHTML = '<p class="loading-text">Loading...</p>'
        const current_city_input = ++latest_city_input

        function callbackShowCity (cities) {
            if (current_city_input === latest_city_input) {
                showCity (cities)
            }
        }

        // If there are input province then show only cities in that province
        if (sort_temp.province != null) {
            $.get(list_city, {province: sort_temp.province}, callbackShowCity)

        // Else Show all cities
        } else {
            $.get(list_city, callbackShowCity)
        }
    })
}

let set_timeout_city_id = null

if (city_search) {
    city_search.addEventListener('input', function (event) {
        const search_value = event.target.value.trim()
        const current_city_input = ++latest_city_input

        const params = sort_temp.province !== null
        ? {search: search_value, province: sort_temp.province}
        : {search: search_value}

        city_options.innerHTML = '<p class="loading-text">Loading...</p>'

        clearTimeout(set_timeout_city_id)

        set_timeout_city_id = setTimeout(() => {
            $.get(list_search_city, params,
                function (cities) {
                    if (current_city_input == latest_city_input) {
                        showCity (cities)
                    }
                }
            )
        }, 300)
    })
}

// Show Cities in filter
function showCity (cities) {
    city_options.innerHTML = ''

    cities.city.forEach((city) => {
        const province = cities.province.find(element => element.id == city.province_id)

        const p_city = document.createElement('p')
        p_city.textContent = city.city + ' [' + province.province_initial + ']'
        city_options.appendChild(p_city)

        p_city.addEventListener('click', function () {
            apply_text_city.textContent = city.city + '[' + province.province_initial + ']'

            apply_city.classList.add('active')
            sort_temp.city = city.id
            sort_temp_names.city = city.city + '[' + province.province_initial + ']'
        })
    })
}

// So that it would not close when clicking city searchbar
if (city_div) {
    city_searchbar.addEventListener('click', function (event) {
        event.stopPropagation()
    })
}

// Sort and Search Section
// For Search

// Creates loading animation
function showLoadingAnimation () {
    list_section.style.display = "flex"
    list_section.style.justifyContent = "center"
    list_section.style.alignItems = "center"

    list_section.innerHTML = `
        <div class="loading-container">
            <span class="loading-text">Loading...</span>
            <div class="blocks-container">
                <div class="loading-block block-1"></div>
                <div class="loading-block block-2"></div>
                <div class="loading-block block-3"></div>
            </div>
        </div>
    `
}

// Create Fallback
function homepageSearchSortFallback () {
    list_section.style.display = "flex"
    list_section.style.justifyContent = "center"
    list_section.style.alignItems = "center"

    list_section.innerHTML = `
        <div class="fallback-container">
            <span class="fallback-text">No context found.</span>
        </div>
    `
}

// Outputs search or sort else fallback
function createConcernCallback (concerns) {
    list_section.style.display = ""
    list_section.style.justifyContent = ""
    list_section.style.alignItems = ""

    list_section.innerHTML = ''
    const concerns_array = concerns.concerns

    if (concerns_array.length !== 0) {
        concerns.concerns.forEach((concern) => {
            const find_city = concerns.cities.find(city => city.id == concern.city_id)
            createConcern (concern, find_city)
        })
    } else {
        homepageSearchSortFallback()
    }
}

let homepage_search_timeout_id = null;
let latest_search_homepage = 0;

search_input.addEventListener('input', function (event) {
    clearTimeout(homepage_search_timeout_id)
    const current_search_homepage = ++latest_search_homepage

    showLoadingAnimation()

    homepage_search_timeout_id = setTimeout(() => {
    
        function guardFetchOutput (concerns) {
            if (current_search_homepage === latest_search_homepage) {
                createConcernCallback(concerns)
            }
        }

        const search_value = event.target.value.trim();

        // If search input is not empty string, search
        if (search_value != '') {
            // If there are sorts
            if (sortChecker()) {
                $.get(
                    search_concerns,
                    {search: search_value, sort: sort},
                    guardFetchOutput
                )

                // Else just do a normal search
            } else {
                $.get(
                    search_concerns,
                    {search: search_value},
                    guardFetchOutput
                )
            }

            // Else if empty string, show index again
        } else {
            // If empty string, but with sort values
            if (sortChecker()) {
                $.get(
                    show_concerns,
                    {sort: sort},
                    guardFetchOutput
                )

                // If empty string, and without sort values
            } else {
                $.get(show_concerns, guardFetchOutput)
            }
        }
    }, 300)
})

// For Deleting applied sorts for status
apply_status.addEventListener('click', function () {
    Object.entries(sort.status).forEach(([key, value]) => {
        sort.status[key] = false
        sort_temp.status[key] = false
    })
    apply_status.classList.remove('active')

    // Resets the icon for each statuses
    if (resolved_icon?.classList.contains('fa-square-check')) {
        resolved_icon.classList.remove('fa-solid', 'fa-square-check')
        resolved_icon.classList.add('fa-regular', 'fa-square')
    
    } else if (pending_icon?.classList.contains('fa-square-check')) {
        pending_icon.classList.remove('fa-solid', 'fa-square-check')
        pending_icon.classList.add('fa-regular', 'fa-square')
        
    } else if (in_progress_icon?.classList.contains('fa-square-check')) {
        in_progress_icon.classList.remove('fa-solid', 'fa-square-check')
        in_progress_icon.classList.add('fa-regular', 'fa-square')

    }  else if (prioritize_icon?.classList.contains('fa-square-check')) {
        prioritize_icon.classList.remove('fa-solid', 'fa-square-check')
        prioritize_icon.classList.add('fa-regular', 'fa-square')
    }
})

// Removes applied div for apply province and removes its temp values
apply_province.addEventListener('click', function () {
    sort_temp.province = null
    sort_temp_names.province = null
    apply_province.classList.remove('active')
    apply_text_province.dispatchEvent(new Event('textChange'))
})

// Removes applied div for apply city and removes its temp values
apply_city.addEventListener('click', function () {
    sort_temp.city = null
    sort_temp_names.city = null
    apply_city.classList.remove('active')
})

// For Sort
apply_filter.addEventListener('click', function() {
    showLoadingAnimation()

    // Puts the temp_sort to sort
    // For status
    const sort_temp_true = Object.values(sort_temp.status).some(value => Boolean(value))
    
    if (sort_temp_true) {
        Object.entries(sort_temp.status).forEach(([key, value]) => {
            sort.status[key] = value
            sort_temp.status[key] = false
        })
    }

    // Stores the values of temp to applied sort objects
    sort.province = sort_temp.province
    sort_names.province = sort_temp_names.province
    // Empties the values of the temp

    sort.city = sort_temp.city
    sort_names.city = sort_temp_names.city
    // Empties the values of the temp

    // Gets the results
    // If there are values in search bar
    const search_value = search_input.value.trim()
    if (search_value != '') {
        $.get(
            sort_concerns,
            {sort: sort, search: search_value},
            createConcernCallback
        )

        // If there are no values in the search bar
    } else {
        $.get(
            sort_concerns,
            {sort: sort},
            createConcernCallback
        )
    }
})

// Clears the sort
clear_button.addEventListener('click', function () {
    showLoadingAnimation()

    // Turns all the status into false value
    Object.entries(sort.status).forEach(([key, value]) => {
        sort.status[key] = false
        sort_temp.status[key] = false
    })

    // Empties the values of sort province and cities
    sort.province = null
    sort_names.province = null
    sort_temp.province = null
    sort.city = null
    sort_names.city = null
    sort_temp.city = null
    apply_text_province.dispatchEvent(new Event('textChange'))

    // Removes status div
    apply_status?.classList.remove('active')
    apply_text_status.textContent = ''

    // Removes province div
    apply_province?.classList.remove('active')
    apply_text_province.textContent = ''

    // Removes city div
    apply_city?.classList.remove('active')
    apply_text_city.textContent = ''

    // Remove Checked Statuses per status
    pending_icon?.classList.remove('fa-solid', 'fa-square-check')
    pending_icon?.classList.add('fa-regular', 'fa-square')

    resolved_icon?.classList.remove('fa-solid', 'fa-square-check')
    resolved_icon?.classList.add('fa-regular', 'fa-square')

    in_progress_icon?.classList.remove('fa-solid', 'fa-square-check')
    in_progress_icon?.classList.add('fa-regular', 'fa-square')

    prioritize_icon?.classList.remove('fa-solid', 'fa-square-check')
    prioritize_icon?.classList.add('fa-regular', 'fa-square')

    // If search input has value
    const search_value = search_input.value.trim()
    if (search_value != '') {
        $.get(
            sort_concerns,
            {search: search_value},
            createConcernCallback
        )

    // Else if search input has empty string
    } else {
        $.get(sort_concerns, createConcernCallback)
    }
})

// Create Concern Cards
// Maps a concern's status to the correct icon, matching the Blade template's @if/@elseif/@else
function getStatusIcon (status) {
    if (status === 'in progress') {
        return ['fa-regular', 'fa-hourglass']
    } else if (status === 'pending') {
        return ['fa-solid', 'fa-circle-exclamation']
    } else {
        return ['fa-solid', 'fa-clipboard-check']
    }
}

// Maps a concern's category to the correct icon, matching the Blade template's @if/@elseif chain
function getCategoryIcon (category) {
    switch (category) {
        case 'Roads':
            return ['fa-solid', 'fa-road']
        case 'Street Light':
            return ['fa-solid', 'fa-lightbulb']
        case 'Sidewalk and Pedestrian':
            return ['fa-solid', 'fa-person-walking']
        case 'Garbage Collection and Waste Disposal':
            return ['fa-solid', 'fa-dumpster']
        case 'Traffic Congestion':
            return ['fa-solid', 'fa-road-circle-exclamation']
        case 'Government Aid Request':
            return ['fa-solid', 'fa-hand-holding-hand']
        case 'Others':
            return ['fa-solid', 'fa-ticket']
        default:
            return ['fa-solid', 'fa-map'] // fallback, Blade has no @else here so this only applies client-side
    }
}

function createConcern (concern, city) {

    const card = document.createElement('div')
    card.classList.add('card')

    // Convert "in progress" -> "in-progress" to match CSS class names
    const status_class = concern.status.replace(/\s+/g, '-')

    // ===== Card Header =====
    const card_header = document.createElement('div')
    card_header.classList.add('card-header')

    const p_header = document.createElement('p')
    p_header.classList.add('header')
    p_header.textContent = concern.title

    const stat_progress = document.createElement('div')
    stat_progress.classList.add('status', status_class)

    const header_p_progress = document.createElement('p')
    header_p_progress.classList.add(status_class)

    const header_icon_progress = document.createElement('span')
    header_icon_progress.classList.add('icon', status_class)

    const header_icon = document.createElement('i')
    header_icon.classList.add(...getStatusIcon(concern.status))

    card.appendChild(card_header)
    card_header.appendChild(p_header)
    card_header.appendChild(stat_progress)
    stat_progress.appendChild(header_p_progress)
    header_p_progress.appendChild(header_icon_progress)
    header_icon_progress.appendChild(header_icon)
    header_p_progress.appendChild(document.createTextNode(concern.status))

    // ===== Details Section =====
    const details = document.createElement('div')
    details.classList.add('details')
    card.appendChild(details)

    // Category (Blade hardcodes 'progress' as the wrapper class, kept as-is to match)
    const category_wrapper = document.createElement('div')
    category_wrapper.classList.add('category-wrapper', 'progress')

    const category_p_progress = document.createElement('p')
    category_p_progress.classList.add('progress')

    const category_icon_progress = document.createElement('span')
    category_icon_progress.classList.add('icon', 'progress')

    const category_icon = document.createElement('i')
    category_icon.classList.add(...getCategoryIcon(concern.category))

    details.appendChild(category_wrapper)
    category_wrapper.appendChild(category_p_progress)
    category_p_progress.appendChild(category_icon_progress)
    category_icon_progress.appendChild(category_icon)
    category_p_progress.appendChild(document.createTextNode(concern.category))

    // Location
    const location_wrapper = document.createElement('div')
    location_wrapper.classList.add('location-wrapper')

    const p_location = document.createElement('p')
    p_location.classList.add('location')

    const location_icon_wrapper = document.createElement('span')
    location_icon_wrapper.classList.add('icon', 'location')

    const location_icon = document.createElement('i')
    location_icon.classList.add('fa-solid', 'fa-location-dot')

    details.appendChild(location_wrapper)
    location_wrapper.appendChild(p_location)
    p_location.appendChild(location_icon_wrapper)
    location_icon_wrapper.appendChild(location_icon)
    p_location.appendChild(document.createTextNode(city.city))

    // ===== Description =====
    const description = document.createElement('div')
    description.classList.add('description')

    const desc_text = document.createElement('p')
    desc_text.textContent = concern.description

    description.appendChild(desc_text)
    card.appendChild(description)

    // ===== Card Footer =====
    const card_footer = document.createElement('div')
    card_footer.classList.add('card-footer')
    card.appendChild(card_footer)

    const footer_interaction_container = document.createElement('div')
    footer_interaction_container.classList.add('interaction-container')
    card_footer.appendChild(footer_interaction_container)

    // Date
    const date = document.createElement('div')
    date.classList.add('date')

    const p_date = document.createElement('p')

    const date_icon = document.createElement('i')
    date_icon.classList.add('fa-regular', 'fa-clock')

    date.appendChild(p_date)
    p_date.appendChild(date_icon)

    const concern_date = new Date(concern.created_at)
    const format_date = new Intl.DateTimeFormat('en-US', { year: 'numeric', month: 'long', day: '2-digit' }).format(concern_date)
    p_date.appendChild(document.createTextNode(' ' + format_date))

    footer_interaction_container.appendChild(date)

    // Priority

    const priority = document.createElement('div')
    priority.classList.add('priority')

    const priority_button = document.createElement('button')
    const priority_icon = document.createElement('i')
    priority_icon.classList.add('fa-solid', 'fa-arrow-up')
    priority_button.appendChild(priority_icon)

    if (concern.is_prioritized) {
        priority_button.classList.add('is-clicked')
    }

    const priority_number = document.createElement('span')
    priority_number.classList.add('priority-text')
    priority_number.textContent = concern.priority_count
    priority_button.append(priority_number)

    const priority_id = document.createElement('span')
    priority_id.classList.add('hidden')
    priority_id.setAttribute('id', concern.id)
    priority_button.append(priority_id)

    priority.appendChild(priority_button)

    footer_interaction_container.appendChild(priority)

    // Share
    const share = document.createElement('div')
    share.classList.add('share')

    const share_button = document.createElement('button')
    const share_icon = document.createElement('i')
    share_icon.classList.add('fa-solid', 'fa-retweet')

    const share_text = document.createElement('span')
    share_text.textContent = 'share'

    share_button.appendChild(share_icon)
    share_button.appendChild(share_text)
    share.appendChild(share_button)

    footer_interaction_container.appendChild(share)

    // View Details link
    const view = document.createElement('div')
    view.classList.add('view')

    const view_link = document.createElement('a')
    view_link.classList.add('links')
    view_link.href = `${concern_details_url}/${concern.id}`

    const view_icon = document.createElement('i')
    view_icon.classList.add('fa-solid', 'fa-arrow-right-long')

    view_link.appendChild(document.createTextNode('View Details '))
    view_link.appendChild(view_icon)
    view.appendChild(view_link)

    card_footer.appendChild(view)

    list_section.appendChild(card)
}

// When document is clicked close the filter div
document.addEventListener('click', function() {
    filter_div.classList.remove('active')

    // Removing status active divs when closed
    pending?.classList.remove('active')
    in_progress?.classList.remove('active')
    resolved?.classList.remove('active')
    prioritize?.classList.remove('active')

    // Remove Checked Statuses per status
    pending_icon?.classList.remove('fa-solid', 'fa-square-check')
    pending_icon?.classList.add('fa-regular', 'fa-square')

    resolved_icon?.classList.remove('fa-solid', 'fa-square-check')
    resolved_icon?.classList.add('fa-regular', 'fa-square')

    in_progress_icon?.classList.remove('fa-solid', 'fa-square-check')
    in_progress_icon?.classList.add('fa-regular', 'fa-square')

    prioritize_icon?.classList.remove('fa-solid', 'fa-square-check')
    prioritize_icon?.classList.add('fa-regular', 'fa-square')

    // Removing province active divs when closed
    // Checks if province_div exists first to prevent interruptions
    if (province_div) {
        province_div.classList.remove('active')
        province_searchbar.classList.remove('active')
        province_options.classList.remove('active')
        if (province_search.value.trim() != '') {
            province_search.value = ''
        }
    }

    // Removing city active divs when closed
    // Checks if city_div exists first to prevent interruptions
    if (city_div) {
        city_div.classList.remove('active')
        city_searchbar.classList.remove('active')
        city_options.classList.remove('active')
        if (city_search.value.trim() != '') {
            city_search.value = ''
        }
    }

    // Empties the values of the temp
    Object.entries(sort_temp.status).forEach(([key, value]) => {
        sort_temp.status[key] = false
    })
    // Empties the values of the temp
    sort_temp_names.province = null
    sort_temp.province = null
    // Empties the values of the temp
    sort_temp_names.city = null
    sort_temp.city = null
})