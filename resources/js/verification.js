// content holder
const content_div = document.querySelector('.user-content')

// csrf token
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

// gets the project url
const project_url = window.location.origin
console.log(project_url)

// Get all the staff verification
$.get(get_verification,
    function (values) {
        createUserVerification (values)
})

function createUserVerification (values) {
    values.to_verify.forEach((value) => {
        const verification_div = document.createElement('div')
        verification_div.classList.add('user-verification')

        // Details section of div
        const details_div = document.createElement('div')
        details_div.classList.add('details-section')

        const details_p = document.createElement('p')
        details_p.textContent = value.username

        const coe_button = document.createElement('button')
        coe_button.textContent = 'View COE'

        verification_div.appendChild(details_div)
        details_div.appendChild(details_p)
        details_div.appendChild(coe_button)

        // Find the coe_path
        const coe_path = values.verify_details.find(details => details.user_id == value.id)

        // When button is clicked, open the coe in new tab
        coe_button.addEventListener('click', function () {
            window.open(('/KayaGov/public/storage/' + coe_path.coe_path), '_blank')
        })

        // action section of div
        const action_div = document.createElement('div')
        action_div.classList.add('action-section')

        const form = document.createElement('form')
        form.action = submit_form
        form.method = 'post'

        // @csrf for form
        const csrf_input = document.createElement('input')
        csrf_input.type = 'hidden'
        csrf_input.name = '_token'
        csrf_input.value = token

        // Get the user_id
        const input_id = document.createElement('input')
        input_id.type = 'hidden'
        input_id.name = 'user_id'
        input_id.value = value.id

        const accept_button = document.createElement('button')
        accept_button.textContent = 'Accept'
        accept_button.type = 'submit'
        accept_button.name = 'submit'
        accept_button.value = 'accept'

        const reject_button = document.createElement('button')
        reject_button.textContent = 'Reject'
        reject_button.type = 'submit'
        reject_button.name = 'submit'
        reject_button.value = 'reject'

        verification_div.appendChild(action_div)
        action_div.appendChild(form)
        form.appendChild(csrf_input)
        form.appendChild(input_id)
        form.appendChild(accept_button)
        form.appendChild(reject_button)

        content_div.appendChild(verification_div)
    })
}