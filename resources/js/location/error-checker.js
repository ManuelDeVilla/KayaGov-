const form = document.querySelector('#form')

const province_input = document.querySelector('#province-input')
const province_label = document.querySelector('#province-label')

const city_input = document.querySelector('#city-input')
const city_label = document.querySelector('#city-label')

const errors = {
    province: false,
    city: false
}

form.addEventListener('submit', function (event) {

    if (province_input.value == '') {
        errors.province = true
        province_label.classList.add('active')
        province_label.classList.remove('hidden')

        province_input.addEventListener('provinceInput', function () {
            console.log('province Changed')
            errors.province = false
            province_label.classList.remove('active')
            province_label.classList.add('hidden')
        })
    }

    if (city_input.value == '') {
        errors.city = true
        city_label.classList.add('active')
        city_label.classList.remove('hidden')

        city_input.addEventListener('cityInput', function () {
            console.log('city Changed')
            errors.province = false
            city_label.classList.remove('active')
            city_label.classList.add('hidden')
        })
    }

    console.log(errors)

    const hasErrors = Object.values(errors).some(value => value == true)

    if (hasErrors) {
        event.preventDefault()
    }
})