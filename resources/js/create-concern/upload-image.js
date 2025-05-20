const upload_wrapper = document.querySelector('.upload-wrapper');
const file_input = document.querySelector('#file-input')
const uploaded_image_wrapper = document.querySelector('.uploaded-image-wrapper')
const uploaded_image_label = document.querySelector('.image-label')

upload_wrapper.addEventListener('click', function () {
    file_input.click();
})

const file_array = []

file_input.addEventListener('change', function (event) {
    const images_filelist = event.target.files
    const images_array = Array.from(images_filelist)
    file_array.push(...images_array)
    const remove_existing_div = document.querySelectorAll('.image-detail-div')

    if (remove_existing_div) {
        remove_existing_div.forEach((existing_div) => {
            existing_div.remove()
        })
    }

    file_array.forEach((file, index) => {
        if (!file) {
            uploaded_image_label.classList.toggle('active')
        }

        const image_detail_div = document.createElement('div')
        image_detail_div.setAttribute('class', 'image-detail-div')

        const image_name_label = document.createElement('label')
        image_name_label.setAttribute('class', 'image-detail-label')
        image_name_label.textContent = file.name

        const delete_image = document.createElement('i')
        delete_image.setAttribute('class', 'fa-solid fa-trash image-detail-delete')

        delete_image.addEventListener('click', function() {
            removeImage(file.name)
            image_detail_div.remove()
            fileValue()
        })

        image_detail_div.appendChild(image_name_label)
        image_detail_div.appendChild(delete_image)
        uploaded_image_wrapper.appendChild(image_detail_div)
    })
    event.target.value = ''
    fileValue()
})

// To remove image
function removeImage(file_name) {
    const delete_image = file_array.findIndex(image => image.name == file_name)
    file_array.splice(delete_image, 1)
}

// Updates the file list of files input
function fileValue () {
    const data_transfer = new DataTransfer()
    file_array.forEach((file) => {
        data_transfer.items.add(file)
    })
    file_input.files = data_transfer.files
}