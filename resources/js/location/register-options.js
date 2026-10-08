const selector_wrapper = document.querySelectorAll('.selector-wrapper')

let thruthful_options = {
    province: false,
    city: false
}

let selected_options = {
    province: false,
    city: false
}

// Per selector do code below
selector_wrapper.forEach((wrapper) => {
    const selector = wrapper.querySelector('.selector')
    const selectorArrow = wrapper.querySelector('#arrow')
    const options = wrapper.querySelector('.options')
    const search_region = wrapper.querySelector('.search-input')
    const selector_type = wrapper.querySelector('.selector_type').value

    search_region.addEventListener('input', function (event) {
        let searchValue = event.target.value
        get_type = 'search'
        selectorType(selector_type, searchValue, wrapper, get_type)
    })

    // Hides the options div if clicked somewhere in the document
    document.addEventListener('click', function (event) {
        if (!selector.contains(event.target) && options.classList.contains('active') && (!search_region.contains(event.target))) {
            options.classList.toggle('active');
            selectorArrow.innerHTML = '&#x1F86A;';
        }
    })

    selector.addEventListener('click', function() {
    
        options.classList.toggle('active');
        let optionIsActive = options.classList.contains('active')

        // Resets the value of the search input inside the option div
        if (search_region.value.trim() != '') {
            search_region.value = ''
        }

        // Hides and shows option div
        if (optionIsActive) {
            selectorArrow.innerHTML = '&#129131;';

            const searchValue = null
            const get_type = 'show'

            if (selector_type == 'city' && selected_options.province) {
                selectorType('city', searchValue, wrapper, get_type, selected_options.province)
            } else {
                selectorType(selector_type, searchValue, wrapper, get_type)
            }

        } else {
            selectorArrow.innerHTML = '&#x1F86A;';
        }
    })
})

// Gets the all values when searched / opened the selector
function selectorType (selector_type, search_value, wrapper, get_type, get_id) {

    const selector_inputs = wrapper.querySelectorAll('.selector-inputs')

    if (selector_inputs) {
        selector_inputs.forEach(selector_input => {
            selector_input.remove()
        })
    }

    // For showing ALL options
    if (get_type == 'show') {
        if (get_id && selector_type == 'province') {
            $.get(getShowSelector,
            {
                province_id: get_id
            },

            function(values) {

                const province_wrapper = document.querySelector('#province-selector')
                const all_inputs = province_wrapper.querySelectorAll('.selector-inputs')

                if (all_inputs) {
                    all_inputs.forEach((value) => {
                        value.remove()
                    })
                }

                values.provinces.forEach((province) => {
                    createOptions (province, province_wrapper, selector_type)
                })

                let cities = new Object()

                values.cities.city.forEach((city_rows) => {
                    const province_index = values.cities.province.find(initial => initial.id == city_rows.province_id)

                    const province_initial = province_index.province_initial

                    cities = {
                        city: city_rows,
                        province: province_initial
                    }

                    createOptions (cities, wrapper, 'city')
                })
            })  

        // 'show' branch
        } else if (get_id && selector_type == 'city') {
            $.get(getShowSelector, { city_id: get_id }, function(values) {
                const city_wrapper = document.querySelector('#city-selector')
                const province_wrapper = document.querySelector('#province-selector')   // 👈 add this

                const all_inputs = city_wrapper.querySelectorAll('.selector-inputs')
                if (all_inputs) {
                    all_inputs.forEach((value) => { value.remove() })
                }

                let cities = new Object()
                values.cities.city.forEach((city_rows) => {
                    const province_index = values.cities.province.find(initial => initial.id == city_rows.province_id)
                    const province_initial = province_index.province_initial
                    cities = { city: city_rows, province: province_initial }
                    createOptions (cities, city_wrapper, selector_type)
                })

                values.provinces.forEach((province) => {
                    createOptions (province, province_wrapper, 'province')   // 👈 fixed
                })
            })

        } else if (selector_type == null) {
            const city_id = selected_options.city
            const province_id = selected_options.province

            $.get(getShowSelector,
            {
                province_id: province_id,
                city_id: city_id
            },

            function(values) {

                const province_wrapper = document.querySelector('#province-selector')
                const city_wrapper = document.querySelector('#city-selector')

                const all_inputs = document.querySelectorAll('.selector-inputs')

                if (all_inputs) {
                    all_inputs.forEach((value) => {
                        value.remove()
                    })
                }

                values.provinces.forEach((province) => {
                    createOptions (province, province_wrapper, 'province')
                })

                let cities = new Object()

                values.cities.city.forEach((city_rows) => {
                    const province_index = values.cities.province.find(initial => initial.id == city_rows.province_id)

                    const province_initial = province_index.province_initial

                    cities = {
                        city: city_rows,
                        province: province_initial
                    }

                    createOptions (cities, city_wrapper, 'city')
                })
            })

        } else {
            $.get(getShowSelector,
            function(values) {
                const all_inputs = document.querySelectorAll('.selector-inputs')

                if (all_inputs) {
                    all_inputs.forEach((value) => {
                        value.remove()
                    })
                }

                switch (selector_type) {
                    case 'province':
                            values.provinces.forEach((province) => {
                                createOptions (province, wrapper, selector_type)
                            })
                        break

                    case 'city':
                        let cities = new Object()

                            values.cities.city.forEach((city_rows) => {
                                const province_index = values.cities.province.find(initial => initial.id == city_rows.province_id)

                                const province_initial = province_index.province_initial

                                cities = {
                                    city: city_rows,
                                    province: province_initial
                                }

                                createOptions (cities, wrapper, selector_type)
                            })
                        break
                }
            })
        }

    // For showing SEARCHED options
    } else if (get_type == 'search') {
        if (get_id && selector_type == 'province') {
            $.get(getSearchSelector,
        {
            search: search_value,
            selector_type: selector_type,
            province_id: get_id
        },

        function(values) {
            const province_wrapper = document.querySelector('#province-selector')
            const all_inputs = province_wrapper.querySelectorAll('.selector-inputs')

            if (all_inputs) {
                all_inputs.forEach((value) => {
                    value.remove()
                })
            }

            values.provinces.forEach((province) => {
                createOptions (province, province_wrapper, selector_type)
            })

            let cities = new Object()

            values.cities.city.forEach((city_rows) => {
                const province_index = values.cities.province.find(initial => initial.id == city_rows.province_id)

                const province_initial = province_index.province_initial

                cities = {
                    city: city_rows,
                    province: province_initial
                }

                createOptions (cities, wrapper, 'city')
            })
        })

        // for search
        } else if (get_id && selector_type == 'city') {
            $.get(getSearchSelector, { search: search_value, selector_type: selector_type, city_id: get_id }, function(values) {
                const city_wrapper = document.querySelector('#city-selector')
                const province_wrapper = document.querySelector('#province-selector')

                const all_inputs = city_wrapper.querySelectorAll('.selector-inputs')
                if (all_inputs) {
                    all_inputs.forEach((value) => { value.remove() })
                }

                let cities = new Object()
                values.cities.city.forEach((city_rows) => {
                    const province_index = values.cities.province.find(initial => initial.id == city_rows.province_id)
                    const province_initial = province_index.province_initial
                    cities = { city: city_rows, province: province_initial }
                    createOptions (cities, city_wrapper, selector_type)
                })

                values.provinces.forEach((province) => {
                    createOptions (province, province_wrapper, 'province')   // 👈 fixed
                })
            })

        } else {
            $.get(getSearchSelector,
            {
                search: search_value,
                selector_type: selector_type
            },

            function(values) {
                const all_inputs = document.querySelectorAll('.selector-inputs')

                if (all_inputs) {
                    all_inputs.forEach((value) => {
                        value.remove()
                    })
                }

                switch (selector_type) {
                    case 'province':
                            values.forEach((province) => {
                                createOptions (province, wrapper, selector_type)
                            })
                        break

                    case 'city':
                            let cities = new Object()

                            values.cities.city.forEach((city_rows) => {
                                const province_index = values.cities.province.find(initial => initial.id == city_rows.province_id)

                                const province_initial = province_index.province_initial

                                cities = {
                                    city: city_rows,
                                    province: province_initial,
                                    province_id: province_index
                                }

                                createOptions (cities, wrapper, selector_type)
                            })
                        break
                }
            })
        }
    }
}

// Search for both city and province
function setupSearchListener (search_region, selector_type, wrapper) {
    if (!search_region) return

    let latest_input_id = 0
    let search_timeout_id = null

    search_region.addEventListener('input', function (event) {
        const searchValue = event.target.value
        const current_input_id = ++latest_input_id

        clearTimeout(search_timeout_id)

        search_timeout_id = setTimeout(() => {
            // filter cities by the currently selected province, if any
            const get_id = selector_type == 'city'
                ? selected_options.province   
                : null

            if (current_input_id === latest_input_id) {
                selectorType(selector_type, searchValue, wrapper, 'search', get_id || null)
            }
        }, 300)
    })
}

// call to get the value of each option once
const city_search_region = document.querySelector('#city-search')
const city_wrapper = document.querySelector('#city-selector')
setupSearchListener(city_search_region, 'city', city_wrapper)

const province_search_region = document.querySelector('#province-search') 
const province_wrapper = document.querySelector('#province-selector')
setupSearchListener(province_search_region, 'province', province_wrapper)

// when a province is clicked reset the value of city
function resetCitySelection () {
    const city_selector_text = city_wrapper.querySelector('.selector_text')
    const city_option_input = city_wrapper.querySelector('.input')

    city_selector_text.textContent = 'Select a City'
    city_option_input.setAttribute('value', '')

    selected_options.city = false
    thruthful_options.city = false
}

// Create each option for dropdown
function createOptions (value, wrapper, selector_type) {
    let input_text_content = null
    let input_value = null
    const selector_text = wrapper.querySelector('.selector_text')
    const options = wrapper.querySelector('.options')
    const option_input = wrapper.querySelector('.input')

    const inputs = document.createElement('p')
    inputs.setAttribute('class', 'selector-inputs');

    switch (selector_type) {
        case 'province':
            inputs.setAttribute('id', value.id);
            inputs.textContent = value.province
            input_text_content = value.province
            input_value = value.id
            break

        case 'city':
            inputs.setAttribute('id', value.city.id);
            inputs.textContent = value.city.city + " [" + value.province + "]"
            input_text_content = value.city.city + " [" + value.province + "]"
            input_value = value.city.id
            break
    }

    inputs.addEventListener('click', function () {
        selector_text.textContent = input_text_content
        option_input.setAttribute('value', input_value)
        thruthful_options[selector_type] = true

        if (selector_type == 'province') {
            if (selected_options.province && selected_options.province !== value.id) {
                resetCitySelection()
            }
            selected_options[selector_type] = value.id
        } else if (selector_type == 'city') {
            selected_options[selector_type] = value.city.province_id
        }

        const searchValue = null
        const get_type = 'show'
        const countTrue = Object.values(selected_options).filter(Boolean).length

        // A province was picked, city not yet chosen → load matching cities
        if (wrapper.id == 'province-selector' && countTrue == 1) {
            selectorType('city', searchValue, city_wrapper, get_type, value.id)

        // A city was picked, province not yet chosen → load & auto-select its province
        } else if (wrapper.id == 'city-selector' && countTrue == 1) {
            selectorType('province', searchValue, province_wrapper, get_type, value.city.province_id)

        // Both are now selected → refresh both lists together
        } else if (countTrue == 2) {
            const province_id = selected_options.province
            selectorType(null, searchValue, wrapper, get_type, province_id)
        }

        if (selector_type == 'province') {
            option_input.dispatchEvent(new Event('provinceInput'))
        } else if (selector_type == 'city') {
            option_input.dispatchEvent(new Event('cityInput'))
        }
    })

    options.appendChild(inputs)
}