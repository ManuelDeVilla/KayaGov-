const selector = document.querySelector('.selector-wrapper')
const options = document.querySelector('.options')
const search_region = document.querySelector('.search-input')
const selectorArrow = document.querySelector('#arrow')

let latest_ajax_request = 0
let debounce_timeout_id = null
let searchValue = null

selector.addEventListener('click', function () {
    options.classList.toggle('active')
    let optionIsActive = options.classList.contains('active')

    // Resets the value of the search input inside the option div
    if (search_region.value.trim() != '') {
        search_region.value = ''
    }

    // Hides and shows option div
    // Creates the options

    if (optionIsActive) {
        selectorArrow.classList.remove('fa-angle-down')
        selectorArrow.classList.add('fa-angle-up')
        requestType()

    } else {
        selectorArrow.classList.remove('fa-angle-up')
        selectorArrow.classList.add('fa-angle-down')
    }
})

// Hides the options div if clicked somewhere in the document
document.addEventListener('click', function (event) {
    if (!selector.contains(event.target) && options.classList.contains('active')) {
        options.classList.toggle('active');
        selectorArrow.classList.remove('fa-angle-up')
        selectorArrow.classList.add('fa-angle-down')

        // Resets the search region if clicked outside the wrapper
        if (search_region.value.trim() != '') {
            search_region.value = ''
        }
    }
})

search_region.addEventListener('click', function (event) {
    event.stopPropagation()
})

search_region.addEventListener('input', function (event) {
    let searchValue = event.target.value
    clearTimeout(debounce_timeout_id)

    debounce_timeout_id = setTimeout(() => {
        const current_ajax = ++latest_ajax_request
        requestType(searchValue, 'search', current_ajax)
    }, 300);
})

function requestType (
    searchValue = null,
    get_type = 'show',
    request_id = null
) {

    const selector_inputs = document.querySelectorAll('.selector-inputs')
    const fallback_text = document.querySelector('#location-fallback-element')

    // Removes existing selectors
    if (selector_inputs || fallback_text) {
        selector_inputs?.forEach(selector_input => {
            selector_input.remove()
        })

        fallback_text?.remove()
    }

    
    switch (get_type) {
        case 'show':
            $.get(show_city, function (cities) {
                console.log(cities)
                if (cities?.city.length !== 0) {
                    cities.city.forEach((city) => {
                        const province_initial = cities.province.find(array => city.province_id == array.id)
                        const province_array = province_initial
                        createOptions(city, province_array)
                    })
                } else {
                    createFallbackOption('Cities')
                }
            })
            break;

        case 'search':
            // console.log('asdasdasda')
            $.get(search_city, {search: searchValue}, function (cities) {
                const selector_inputs = document.querySelectorAll('.selector-inputs')

                // Removes existing selectors
                if (selector_inputs) {
                    selector_inputs.forEach(selector_input => {
                       selector_input.remove()
                    })
                }

                if (request_id != latest_ajax_request) {
                    return false
                }

                if (cities?.city.length !== 0) {
                    cities.city.forEach((city) => {
                    const province_initial = cities.province.find(array => city.province_id == array.id)
                    const province_array = province_initial
                    createOptions(city, province_array)
                })
                } else {
                    createFallbackOption(`City named ${searchValue}`)
                }
            })
            break
    }
}

function createOptions (city, province_array) {

    const selector_text = document.querySelector('.selector_text')
    const options = document.querySelector('.options')
    const option_input = document.querySelector('#city')

    const inputs = document.createElement('p')
    inputs.setAttribute('id', city.id);
    inputs.setAttribute('class', 'selector-inputs')

    inputs.textContent = city.city + " [" + province_array.province_initial + "]"
    const input_text_content = city.city + " [" + province_array.province_initial + "]"

    inputs.addEventListener('click', function () {
        selector_text.textContent = input_text_content
        option_input.dispatchEvent(new Event('change'))
        option_input.setAttribute('value', city.id)
    })

    options.appendChild(inputs)
}

function createFallbackOption (type = null) {
    console.log('asdasd')
    const fallbackElement = document.createElement('p')
    fallbackElement.className = 'location-fallback'
    fallbackElement.textContent =  `No ${type} found`
    fallbackElement.id = 'location-fallback-element'

    options.appendChild(fallbackElement);
}