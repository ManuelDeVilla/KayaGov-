// Form
const form = document.querySelector('#form')

// submit button
const submit_button = document.querySelector('.submit')

// inputs
const title_input = document.querySelector('#title')
const title_span = document.querySelector('#title-span')
const desc_input = document.querySelector('#description')
const desc_span = document.querySelector('#desc-span')
const category_input = document.querySelector('#category')
const category_span = document.querySelector('#category-span')
const city_input = document.querySelector('#city')
const city_span = document.querySelector('#city-span')

form.addEventListener('submit', function (event) {
    let errors = {}
    // If Title input is empty do not submit else submit or remove required
    if (title_input.value.trim() == '') {
        title_span.classList.add('active')
        errors.title = true
        title_input.addEventListener('input', function (event) {
            if (event.target.value.trim() == '') {
                title_span.classList.add('active')
                errors.title = true
            } else {
                title_span.classList.remove('active')
                errors.title = false
            }
        })
    }

    // If Desc input is empty do not submit else submit or remove required
    if (desc_input.value.trim() == '') {
        desc_span.classList.add('active')
        errors.desc = true
        desc_input.addEventListener('input', function (event) {
            if (event.target.value.trim() == '') {
                desc_span.classList.add('active')
                errors.desc = true
            } else {
                desc_span.classList.remove('active')
                errors.desc = false
            }
        })
    }

    // If Cateogry input is empty do not submit else submit or remove required
    if (category_input.value == '') {
        category_span.classList.add('active')
        errors.category = true
        category_input.addEventListener('change', function (event) {
            category_span.classList.remove('active')
            errors.category = false
        })
    }

    // If Cateogry input is empty do not submit else submit or remove required
    if (city_input.value == '') {
        city_span.classList.add('active')
        errors.city = true
    }

    city_input.addEventListener('change', function () {
        if (errors.city == true) {
            city_span.classList.remove('active')
            errors.city = false
        }
    })

    // Find if there are true in each keys
    const hasErrors = Object.entries(errors).find(([keys, value]) => value)
    
    // If there are errors, do not submit the form
    if (hasErrors) {
        event.preventDefault()
    }
})