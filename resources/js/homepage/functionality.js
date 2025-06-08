// Code For Sharing
// get anchor to get the link
const anchors = document.querySelectorAll('.links')

// Share Button
const share_button = document.querySelectorAll('.share')

// Message Wrapper
const link_message = document.querySelector('.message')

// Close Message
const close_message = document.querySelector('.clickable')

anchors.forEach((anchor, index) => {
    const get_link = anchor.getAttribute('href')

    share_button[index].addEventListener('click', function () {
        navigator.clipboard.writeText(get_link)
        link_message.classList.add('active')
        close_message.addEventListener('click', function() {
            link_message.classList.remove('active')
        })
    })
})

// Code for adding priority
const priorities = document.querySelectorAll('.priority')

priorities.forEach((priority) => {
    const priority_text = priority.querySelector('.priority-text')
    const concern_id = priority.querySelector('.hidden').id

    priority.addEventListener('click', function () {
        $.get(add_priority,
            {
                user_id: user_id,
                concern_id: concern_id
            },
            function (count) {
                console.log('asdasdas')
                priority_text.textContent = count
            }
        )
    })
})