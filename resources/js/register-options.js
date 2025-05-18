const selector_wrapper = document.querySelectorAll('.selector-wrapper')

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
            selectorType(selector_type, searchValue, wrapper, get_type)

            search_region.addEventListener('input', function (event) {
                let searchValue = event.target.value
                get_type = 'search'
                selectorType(selector_type, searchValue, wrapper, get_type)
            })
        } else {
            selectorArrow.innerHTML = '&#129131;';
        }
    })
})

// Gets the all values when searched / opened the selector
function selectorType (selector_type, search_value, wrapper, get_type) {

    const selector_inputs = wrapper.querySelectorAll('.selector-inputs')

    if (selector_inputs) {
        selector_inputs.forEach(selector_input => {
            selector_input.remove()
        })
    }

    // For showing ALL options
    if (get_type == 'show') {
        $.get(getShowSelector,
        {
            selector_type: selector_type
        },

        function(values) {
            switch (selector_type) {
                case 'region':
                        values.regions.forEach((region) => {
                            createOptions (region, wrapper, selector_type)
                        })
                    break
                
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

        // For showing SEARCHED options
    } else if (get_type == 'search') {
        $.get(getSearchSelector,
        {
            search: search_value,
            selector_type: selector_type
        },

        function(values) {

            switch (selector_type) {
                case 'region':
                        values.forEach((region) => {
                            createOptions (region, wrapper, selector_type)
                        })
                    break
                
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

function createOptions (value, wrapper, selector_type) {
    let input_text_content = null
    let input_value = null
    const selector_text = wrapper.querySelector('.selector_text')
    const options = wrapper.querySelector('.options')
    const option_input = wrapper.querySelector('.input')

    const inputs = document.createElement('p')
    inputs.setAttribute('id', value.id);
    inputs.setAttribute('class', 'selector-inputs');

    switch (selector_type) {
        case 'region':
            inputs.textContent = value.regions
            input_text_content = value.regions
            input_value = value.id
            break
        
        case 'province':
            inputs.textContent = value.province
            input_text_content = value.province
            input_value = value.id
            break

        case 'city':
            console.log(value)
            inputs.textContent = value.city.city + " [" + value.province + "]"
            input_text_content = value.city.city + " [" + value.province + "]"
            input_value = value.city.id
            break
    }

    inputs.addEventListener('click', function () {
        selector_text.textContent = input_text_content
        option_input.setAttribute('value', input_value)
    })

    options.appendChild(inputs)
}