// Delegate both click behaviors to the whole comments section,
// so this works for every comment (and every reply-toggle/see-reply button)
// without needing unique IDs or re-binding listeners after any DOM changes.
const comments_section = document.querySelector('.comments-section')

comments_section.addEventListener('click', function (event) {
    // Handle "Reply" button clicks
    const reply_toggle = event.target.closest('.reply-toggle')
    if (reply_toggle) {
        const comment_div = reply_toggle.closest('.comment')

        const reply_form_container = comment_div.querySelector('.reply-form-container')
        const comment_replies = comment_div.querySelector('.comment-replies')
        const see_reply_btn = comment_div.querySelector('.see-reply')

        // Toggle reply input form visibility
        reply_form_container.classList.toggle('hidden')

        // If the reply form is now visible, also force the replies list open
        // (only if there are actually replies to show)
        if (!reply_form_container.classList.contains('hidden') && comment_replies) {
            comment_replies.classList.remove('hidden')
            if (see_reply_btn) {
                see_reply_btn.textContent = 'Hide Replies'
            }
        }

        return
    }

    // Handle "See Replies" / "Hide Replies" button clicks
    const see_reply_btn = event.target.closest('.see-reply')
    if (see_reply_btn) {
        const comment_div = see_reply_btn.closest('.comment')
        const comment_replies = comment_div.querySelector('.comment-replies')

        if (!comment_replies) return

        if (comment_replies.classList.contains('hidden')) {
            see_reply_btn.textContent = 'Hide Replies'
        } else {
            see_reply_btn.textContent = 'See Replies'
        }

        comment_replies.classList.toggle('hidden')
    }
})