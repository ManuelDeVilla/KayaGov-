// Get the form
const form = document.querySelector('#form')

// Get the file input
const file_input = document.querySelector('#file')

// Div to activate the input
const upload_div = document.querySelector('#upload-div')

// Get the div of file to put file details
const uploaded_files_div = document.querySelector('.uploaded-files-wrapper')

// Error Handler
const error_label = document.querySelector('#file-label')

upload_div.addEventListener('click', function () {
    file_input.click()
})

file_input.addEventListener('change', function (event) {

    const existing_file_div = document.querySelector('.uploaded-files')

    if (existing_file_div) {
        existing_file_div.remove()
    }

    const uploaded_file = event.target.files[0]

    const file_div = document.createElement('div')
    file_div.classList.add('uploaded-files')

    const file_name = document.createElement('p')
    file_name.textContent = uploaded_file.name

    const remove_icon = document.createElement('i')
    remove_icon.classList.add('fa-solid', 'fa-xmark')

    file_div.appendChild(file_name)
    file_div.appendChild(remove_icon)

    uploaded_files_div.appendChild(file_div)

    remove_icon.addEventListener('click', function () {
        const existing_file_div = document.querySelector('.uploaded-files')

        if (existing_file_div) {
            existing_file_div.remove()
        }

        file_input.value = ''
        console.log(file_input.files)
    })
})

let hasErrors = false

form.addEventListener('submit', function (event) {
    if (file_input.files.length == 0) {
        hasErrors = true
        error_label.classList.remove('hidden')
        error_label.classList.add('active')

        file_input.addEventListener('change', function() {
            hasErrors = false
            error_label.classList.add('hidden')
            error_label.classList.remove('active')
        })
    }

    if (hasErrors) {
        event.preventDefault()
    }
})