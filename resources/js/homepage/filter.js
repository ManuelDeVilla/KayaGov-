// Get Filter button
const filter_button = document.querySelector('.filter')

// Get Filter div
const filter_div = document.querySelector('#option-wrapper')

// Display filter div
filter_button.addEventListener('click', function () {
    filter_div.classList.toggle('active')
})

// Close the filter div
document.addEventListener('click', function (event) {
    if (event.target != filter_button) {
        filter_div.classList.remove('active')
    }
})

// Toggling Province div
// Getting Elements
const province_div = document.querySelector('#province')
const province_searchbar = document.querySelector('#province-searchbar')
const province_options = document.querySelector('#province-options')

// When province is click show province options & search div
province_div.addEventListener('click', function() {
    province_div.classList.toggle('active')
    province_searchbar.classList.toggle('active')
    province_options.classList.toggle('active')
})

// Toggling City Divs
// Getting City Elements
const city_div = document.querySelector('#city')
const city_searchbar = document.querySelector('#city-searchbar')
const city_options = document.querySelector('#city-options')

// When province is click show city options & search div
city_div.addEventListener('click', function() {
    city_div.classList.toggle('active')
    city_searchbar.classList.toggle('active')
    city_options.classList.toggle('active')
})
