const selector = document.querySelector('.selector-wrapper')
const options = document.querySelector('.options')
const search_region = document.querySelector('.search-input')
const selectorArrow = document.querySelector('#arrow')

let latest_ajax_request = 0

selector.addEventListener('click', function () {
    options.classList.toggle('active')
    let optionIsActive = options.classList.contains('active')

    // Resets the value of the search input inside the option div
    if (search_region.value.trim() != '') {
        search_region.value = ''
    }

    search_region.addEventListener('click', function (event) {
        event.stopPropagation()
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

    // Hides and shows option div
    if (optionIsActive) {
        selectorArrow.classList.remove('fa-angle-down')
        selectorArrow.classList.add('fa-angle-up')

        // Creates the options
        let searchValue = null
        var get_type = 'show'
        requestType(searchValue, get_type, null)

        search_region.addEventListener('input', function (event) {
            let searchValue = event.target.value
            get_type = 'search'

            const current_ajax = ++latest_ajax_request

            requestType(searchValue, get_type, current_ajax)
        })

    } else {
        selectorArrow.classList.remove('fa-angle-up')
        selectorArrow.classList.add('fa-angle-down')
    }
})

function requestType (searchValue, get_type, request_id) {

    const selector_inputs = document.querySelectorAll('.selector-inputs')

    // Removes existing selectors
    if (selector_inputs) {
        selector_inputs.forEach(selector_input => {
            selector_input.remove()
        })
    }
    
    switch (get_type) {
        case 'show':
            $.get(show_city, function (cities) {
                cities.city.forEach((city) => {
                    const province_initial = cities.province.find(array => city.province_id == array.id)
                    const province_array = province_initial
                    createOptions(city, province_array)
                })
            })
            break

        case 'search':
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

                cities.city.forEach((city) => {

                    const province_initial = cities.province.find(array => city.province_id == array.id)
                    const province_array = province_initial
                    createOptions(city, province_array)
                })
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