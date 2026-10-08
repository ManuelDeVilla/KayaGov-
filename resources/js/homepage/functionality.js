// Message Wrapper
const link_message = document.querySelector('.message')

// Close Message
const close_message = document.querySelector('.clickable')

// The container survives every re-render from filter.js, so we bind here once.
const list_section = document.querySelector('.list-section')

if (close_message) {
    close_message.addEventListener('click', function () {
        link_message.classList.remove('active')
    })
}

// Tracks in-flight priority requests by concern id (replaces the per-card is_pending flag)
const pending_priorities = new Set()

list_section.addEventListener('click', function (event) {
    const share = event.target.closest('.share')
    if (share) {
        handleShare(share)
        return
    }

    const priority = event.target.closest('.priority')
    if (priority) {
        handlePriority(priority)
    }
})

// ===== Share =====
function handleShare (share) {
    const card = share.closest('.card')
    const anchor = card?.querySelector('.links')
    if (!anchor) return

    // anchor.href resolves to an absolute URL, unlike getAttribute('href')
    navigator.clipboard.writeText(anchor.href)
        .then(() => link_message.classList.add('active'))
        .catch(() => console.error('Clipboard write failed'))
}

// ===== Priority =====
function handlePriority (priority) {
    const button = priority.querySelector('button')
    const priority_text = priority.querySelector('.priority-text')
    const priority_icon = priority.querySelector('button i')
    const concern_id = priority.querySelector('.hidden')?.id

    if (!button || !priority_text || !concern_id) return
    if (pending_priorities.has(concern_id)) return

    pending_priorities.add(concern_id)

    const current_count = Number(priority_text.textContent)
    // The button carries the is-clicked state in both Blade and createConcern
    const delta = button.classList.contains('is-clicked') ? -1 : 1

    toggleClickedState(button, priority_icon, priority_text)
    priority_text.textContent = current_count + delta

    $.get(add_priority, { user_id: user_id, concern_id: concern_id })
        .done(function (count) {
            priority_text.textContent = count
        })
        .fail(function () {
            // Roll back both the count and the visual state
            toggleClickedState(button, priority_icon, priority_text)
            priority_text.textContent = current_count
        })
        .always(function () {
            pending_priorities.delete(concern_id)
        })
}

function toggleClickedState (button, icon, text) {
    button.classList.toggle('is-clicked')
    icon?.classList.toggle('is-clicked')
    text?.classList.toggle('is-clicked')
}
