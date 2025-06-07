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

    selector.addEventListener('click', function() {
        
        options.classList.toggle('active');
        let optionIsActive = options.classList.contains('active')

        // Resets the value of the search input inside the option div
        if (search_region.value.trim() != '') {
            search_region.value = ''
        }

        // Hides the options div if clicked somewhere in the document
        document.addEventListener('click', function (event) {
            if (!selector.contains(event.target) && options.classList.contains('active') && (!search_region.contains(event.target))) {
                options.classList.toggle('active');
                selectorArrow.innerHTML = '&#129131;';
            }
        })

        // Hides and shows option div
        if (optionIsActive) {
            selectorArrow.innerHTML = '&#129129;';

            // Creates the options
            let searchValue = null
            var get_type = 'show'

            // Shows ALL the cities AND provinces
            if (!Object.values(thruthful_options).includes(true)) {
                selectorType(selector_type, searchValue, wrapper, get_type)

                search_region.addEventListener('input', function (event) {
                    let searchValue = event.target.value
                    get_type = 'search'
                    selectorType(selector_type, searchValue, wrapper, get_type)
                })
            }

        } else {
            selectorArrow.innerHTML = '&#129131;';
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

        } else if (get_id && selector_type == 'city') {
            $.get(getShowSelector,
            {
                city_id: get_id
            },

            function(values) {
                const city_wrapper = document.querySelector('#city-selector')

                const all_inputs = city_wrapper.querySelectorAll('.selector-inputs')

                if (all_inputs) {
                    all_inputs.forEach((value) => {
                        value.remove()
                    })
                }

                let cities = new Object()

                values.cities.city.forEach((city_rows) => {
                    const province_index = values.cities.province.find(initial => initial.id == city_rows.province_id)

                    const province_initial = province_index.province_initial

                    cities = {
                        city: city_rows,
                        province: province_initial
                    }

                    createOptions (cities, city_wrapper, selector_type)
                })

                values.provinces.forEach((province) => {
                    createOptions (province, wrapper, 'province')
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

        } else if (get_id && selector_type == 'city') {
            $.get(getSearchSelector,
            {
                search: search_value,
                selector_type: selector_type,
                city_id: get_id
            },

            function(values) {
                const city_wrapper = document.querySelector('#city-selector')

                const all_inputs = city_wrapper.querySelectorAll('.selector-inputs')

                if (all_inputs) {
                    all_inputs.forEach((value) => {
                        value.remove()
                    })
                }

                let cities = new Object()

                values.cities.city.forEach((city_rows) => {
                    const province_index = values.cities.province.find(initial => initial.id == city_rows.province_id)

                    const province_initial = province_index.province_initial

                    cities = {
                        city: city_rows,
                        province: province_initial
                    }

                    createOptions (cities, city_wrapper, selector_type)
                })

                values.provinces.forEach((province) => {
                    createOptions (province, wrapper, 'province')
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
            selected_options[selector_type] = value.id
        } else if (selector_type == 'city') {
            selected_options[selector_type] = value.city.province_id
        }

        let searchValue = null
        var get_type = 'show'

        const countTrue = Object.values(selected_options).filter(Boolean).length

        if (wrapper.id == 'province-selector' && countTrue == 1) {
            const selector_type = 'city'
            selectorType (selector_type, searchValue, wrapper, get_type, value.id)
            const search_region = document.querySelector('#city-search')

            search_region.addEventListener('input', function (event) {
                let searchValue = event.target.value
                get_type = 'search'
                selectorType(selector_type, searchValue, wrapper, get_type, value.id)
            })

        } else if (wrapper.id == 'city-selector' && countTrue == 1) {
            const selector_type = 'province'
            selectorType (selector_type, searchValue, wrapper, get_type, value.city.province_id)
            const search_region = document.querySelector('#city-search')

            search_region.addEventListener('input', function (event) {
                let searchValue = event.target.value
                get_type = 'search'
                selectorType(selector_type, searchValue, wrapper, get_type, value.city.province_id)
            })

        } else if (countTrue == 2) {
            const province_id = selected_options.province
            selectorType (null, searchValue, wrapper, get_type, province_id)
        }

        // Dispatch event for error checker
        if (selector_type == 'province') {
            option_input.dispatchEvent(new Event('provinceInput'))
        } else if (selector_type == 'city') {
            option_input.dispatchEvent(new Event('cityInput'))
        }
    })

    options.appendChild(inputs)
}