// Form
const form = document.querySelector('#form')

// Different type of inputs
const username_label = document.querySelector('#username-label')
const username_input = document.querySelector('#username')


const email_input = document.querySelector('#email')
const email_label = document.querySelector('#email-label')

const gender_input = document.querySelector('#gender')
const gender_label = document.querySelector('#gender-label')

const password_input = document.querySelector('#password')
const password_label = document.querySelector('#password-label')

const confirmation_input = document.querySelector('#password_confirmation')
const confirmation_label = document.querySelector('#password_confirmation_label')

const usertype_input = document.querySelector('#usertype')
const usertype_label = document.querySelector('#usertype-label')


// Buttons for usertypes
const government_button = document.querySelector('#government-button')
const admin_button = document.querySelector('#admin-button')

// If clicked add effects and set the input to its specified usertype
if (government_button) {
    government_button.addEventListener('click', function () {
        if (admin_button.classList.contains('active')) {
            admin_button.classList.remove('active')
        }
        government_button.classList.add('active')
        usertype_input.setAttribute('value', 'staff')
        usertype_input.dispatchEvent(new Event('change'))
    })
}

// If clicked add effects and set the input to its specified usertype
if (admin_button) {
    admin_button.addEventListener('click', function () {
        if (government_button.classList.contains('active')) {
            government_button.classList.remove('active')
        }
        admin_button.classList.add('active')
        usertype_input.setAttribute('value', 'admin')
        usertype_input.dispatchEvent(new Event('change'))
    })
}

const errors = {}

form.addEventListener('submit', function(event) {
    console.log('bullshit')
    // If username is too short
    if (username_input.value.trim().length < 3) {
        let text_content = 'Username too short. Username should be 3 - 16 characters.'
        errorUsername (text_content)

        // creates an event listener for each combination of errors that can happen
        username_input.addEventListener('input', function (event) {
            if (event.target.value.trim().length < 3) {
                text_content = 'Username too short. Username should be 3 - 16 characters.'
                errorUsername (text_content)

            } else if (event.target.value.trim().length > 16) {
                text_content = 'Username too long. Username should be 3 - 16 characters.'
                errorUsername (text_content)

            } else {
                errors.username = false
                username_label.textContent = 'Username Should be 3 - 16 characters.'
                username_label.classList.remove('active')
            }
        })

        // If username is too long
    } else if (username_input.value.trim().length > 16) {
        let text_content = 'Username too long. Username should be 3 - 16 characters.'
        errorUsername (text_content)

        // creates an event listener for each combination of errors that can happen
        username_input.addEventListener('input', function (event) {
            if (event.target.value.trim().length < 3) {
                text_content = 'Username too short. Username should be 3 - 16 characters.'
                errorUsername (text_content)

            } else if (event.target.value.trim().length > 16) {
                text_content = 'Username too long. Username should be 3 - 16 characters.'
                errorUsername (text_content)

            } else {
                errors.username = false
                username_label.textContent = 'Username Should be 3 - 16 characters'
                username_label.classList.remove('active')
            }
        })
    }

    // Email Error Handler
    if (email_input.value.trim() != '') {
        // If there is an input, but not an email
        if (!email_input.checkValidity()) {
            errors.email = true
            email_label.textContent = 'Please input a working email.'
            email_label.classList.add('active')
            email_label.classList.remove('hidden')

            email_input.addEventListener('input', function (event) {
                errorEmail (event)
            })
        }
    } else {
        errors.email = true
        email_label.textContent = 'Please input your Email Mah Nigg@.'
        email_label.classList.add('active')
        email_label.classList.remove('hidden')

        email_input.addEventListener('input', function (event) {
            errorEmail (event)
        })
    }

    // Gender Error Handler
    if (gender_input.value == '') {
        errors.gender = true

        gender_label.classList.add('active')
        gender_label.classList.remove('hidden')

        gender_input.addEventListener('change', function (event) {
            if (event.target.value != '') {
                errors.gender = false

                gender_label.classList.remove('active')
                gender_label.classList.add('hidden')
            }
        })
    }

    // Password Error Handler
    if (password_input.value.trim() == '') {
        errors.password = true

        password_label.textContent = 'Please input your password.'
        password_label.classList.add('active')
        password_label.classList.remove('hidden')

        password_input.addEventListener('input', function (event) {
            errorPassword (event)
        })

    } else if (password_input.value.trim().length < 6) {
        errors.password = true

        password_label.textContent = 'Password too short. Password should be 6 - 20 characters.'
        password_label.classList.add('active')
        password_label.classList.remove('hidden')
                
        password_input.addEventListener('input', function (event) {
            errorPassword (event)
        })

    } else if (password_input.value.trim().length > 20) {
        errors.password = true

        password_label.textContent = 'Password too long. Password should be 6 - 20 characters.'
        password_label.classList.add('active')
        password_label.classList.remove('hidden')
                
        password_input.addEventListener('input', function (event) {
            errorPassword (event)
        })
    }

    if (confirmation_input.value.trim() != password_input.value.trim() && password_input.value.trim() != '') {
        errors.confirmation = true
        confirmation_label.classList.add('active')
        confirmation_label.classList.remove('hidden')

        confirmation_input.addEventListener('input', function (event) {
            if (confirmation_input.value.trim() != password_input.value.trim()) {
                errors.confirmation = true
                confirmation_label.classList.add('active')
                confirmation_label.classList.remove('hidden')

            } else {
                errors.confirmation = false
                confirmation_label.classList.remove('active')
                confirmation_label.classList.add('hidden')
            }
        })
    }

    if (usertype_input) {
        if (usertype_input.value == '') {
            errors.usertype = true

            usertype_label.classList.add('active')
            usertype_label.classList.remove('hidden')
            
            usertype_input.addEventListener('change', function () {
                errors.usertype = false

                usertype_label.classList.remove('active')
                usertype_label.classList.add('hidden')
            })
        }
    }

    console.log(errors)
    // Checks if there are true in the object
    const hasErrors = Object.values(errors).some(value => value == true)

    // If there are true, do not submit the form
    if (hasErrors) {
        event.preventDefault()
    }
})

function errorUsername (text_content) {
    errors.username = true
    console.log(errors)

    username_label.textContent = text_content
    username_label.classList.add('active')
    username_label.classList.remove('hidden')
}

function errorEmail (event) {
    console.log('working')
    if (event.target.value.trim() == '') {
        errors.email = true
        email_label.textContent = 'Please input your Email Mah Nigg@.'
        email_label.classList.add('active')
        email_label.classList.remove('hidden')

    } else if (!email_input.checkValidity()) {
        errors.email = true
        email_label.textContent = 'Please input a working email.'
        email_label.classList.add('active')
        email_label.classList.remove('hidden')

    } else {
        errors.email = false
        email_label.classList.remove('active')
        email_label.classList.add('hidden')
    }
}

function errorPassword (event) {
    if (event.target.value.trim() == '') {
            errors.password = true

            password_label.textContent = 'Please input your password.'
            password_label.classList.add('active')
            password_label.classList.remove('hidden')

    } else if (event.target.value.trim().length < 6) {
            errors.password = true

            password_label.textContent = 'Password too short. Password should be 6 -20 characters long.'
            password_label.classList.add('active')
            password_label.classList.remove('hidden')

    } else if (event.target.value.trim().length > 20) {
            errors.password = true

            password_label.textContent = 'Password too long. Password should be 6 -20 characters long.'
            password_label.classList.add('active')
            password_label.classList.remove('hidden')

    } else {
            errors.password = false

            password_label.textContent = 'Password should be 6 - 20 characters.'
            password_label.classList.remove('active')
            password_label.classList.add('hidden')
    }
}