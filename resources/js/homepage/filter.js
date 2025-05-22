// Get Filter button
const filter_button = document.querySelector('.filter')

// Get Filter div
const filter_div = document.querySelector('#option-wrapper')

// When document is clicked close the filter div
document.addEventListener('click', function() {
    filter_div.classList.remove('active')
})

// Display filter div
filter_button.addEventListener('click', function (event) {
    // Stops event listener of the parent
    event.stopPropagation()
    filter_div.classList.add('active')
})

filter_div.addEventListener('click', function (event) {
    event.stopPropagation()
})

// For toggling sort by
const sort_by = document.querySelector('#sort-by')
const pending = document.querySelector('#pending')
const in_progress = document.querySelector('#in_progress')
const resolved = document.querySelector('#resolved')

sort_by.addEventListener('click', function () {
    pending.classList.toggle('active')
    in_progress.classList.toggle('active')
    resolved.classList.toggle('active')
})

// Toggling on each sort-by
const sort_children_div = sort_by.querySelectorAll('div')

const pending_icon = document.querySelector('#pending-icon')
const in_progress_icon = document.querySelector('#in-progress-icon')
const resolved_icon = document.querySelector('#resolved-icon')

sort_children_div.forEach((children_div) => {
const id = children_div.id

    children_div.addEventListener('click', function (event) {
    
        switch (id) {
            case 'pending':
                event.stopPropagation()

                if (pending_icon.classList.contains('fa-square')) {
                    if (in_progress_icon.classList.contains('fa-square-check')) {
                        in_progress_icon.classList.remove('fa-solid', 'fa-square-check')
                        in_progress_icon.classList.add('fa-regular', 'fa-square')
                    }

                    if (resolved_icon.classList.contains('fa-square-check')) {
                        resolved_icon.classList.remove('fa-solid', 'fa-square-check')
                        resolved_icon.classList.add('fa-regular', 'fa-square')
                    }

                    pending_icon.classList.remove('fa-regular', 'fa-square')
                    pending_icon.classList.add('fa-solid', 'fa-square-check')
                } else {
                    pending_icon.classList.remove('fa-solid', 'fa-square-check')
                    pending_icon.classList.add('fa-regular', 'fa-square')
                }
                break

            case 'in_progress':
                event.stopPropagation()

                if (in_progress_icon.classList.contains('fa-square')) {

                    if (pending_icon.classList.contains('fa-square-check')) {
                        pending_icon.classList.remove('fa-solid', 'fa-square-check')
                        pending_icon.classList.add('fa-regular', 'fa-square')
                    }

                    if (resolved_icon.classList.contains('fa-square-check')) {
                        resolved_icon.classList.remove('fa-solid', 'fa-square-check')
                        resolved_icon.classList.add('fa-regular', 'fa-square')
                    }

                    in_progress_icon.classList.remove('fa-regular', 'fa-square')
                    in_progress_icon.classList.add('fa-solid', 'fa-square-check')
                } else {
                    in_progress_icon.classList.remove('fa-solid', 'fa-square-check')
                    in_progress_icon.classList.add('fa-regular', 'fa-square')
                }
                break

            case 'resolved':
                event.stopPropagation()

                if (resolved_icon.classList.contains('fa-square')) {

                    if (in_progress_icon.classList.contains('fa-square-check')) {
                        in_progress_icon.classList.remove('fa-solid', 'fa-square-check')
                        in_progress_icon.classList.add('fa-regular', 'fa-square')
                    }

                    if (pending_icon.classList.contains('fa-square-check')) {
                        pending_icon.classList.remove('fa-solid', 'fa-square-check')
                        pending_icon.classList.add('fa-regular', 'fa-square')
                    }

                    resolved_icon.classList.remove('fa-regular', 'fa-square')
                    resolved_icon.classList.add('fa-solid', 'fa-square-check')
                } else {
                    resolved_icon.classList.remove('fa-solid', 'fa-square-check')
                    resolved_icon.classList.add('fa-regular', 'fa-square')
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

// When province is click show province options & search div
province_div.addEventListener('click', function() {
    province_div.classList.toggle('active')
    province_searchbar.classList.toggle('active')
    province_options.classList.toggle('active')
})

// So that it would not close when clicking province searchbar
province_searchbar.addEventListener('click', function (event) {
    event.stopPropagation()
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

// So that it would not close when clicking city searchbar
city_searchbar.addEventListener('click', function (event) {
    event.stopPropagation()
})
