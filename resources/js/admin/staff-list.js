const search_input = document.querySelector('#staff-search-input')
const usertype_select = document.querySelector('#filter-usertype')
const province_select = document.querySelector('#filter-province')
const city_select = document.querySelector('#filter-city')
const table_body = document.querySelector('#staff-list-body')

let latest_request_id = 0
let search_timeout_id = null

usertype_select.addEventListener('change', fetchStaffList)

province_select.addEventListener('change', function () {
    const province_id = province_select.value

    city_select.innerHTML = '<option value="">All Cities</option>'

    if (province_id) {
        $.get(list_city_by_province, { province: province_id }, function (values) {
            values.city.forEach((city) => {
                const option = document.createElement('option')
                option.value = city.id
                option.textContent = city.city
                city_select.appendChild(option)
            })
        })
    }

    fetchStaffList()
})

city_select.addEventListener('change', fetchStaffList)

search_input.addEventListener('input', function () {
    clearTimeout(search_timeout_id)
    search_timeout_id = setTimeout(fetchStaffList, 300)
})

function fetchStaffList () {
    const current_request_id = ++latest_request_id

    const params = {
        search: search_input.value.trim(),
        usertype: usertype_select.value,
        province: province_select.value,
        city: city_select.value
    }

    $.get(staff_list_url, params, function (response) {
        if (current_request_id !== latest_request_id) return
        renderStaffTable(response.staff)
    })
}

function renderStaffTable (staff) {
    table_body.innerHTML = ''

    if (staff.length === 0) {
        table_body.innerHTML = `
            <tr>
                <td colspan="9" class="no-staff">No users found.</td>
            </tr>
        `
        return
    }

    staff.forEach((member, index) => {
        const row = document.createElement('tr')

        const cells = [
            index + 1,
            member.username,
            member.email,
            member.gender,
            member.usertype.charAt(0).toUpperCase() + member.usertype.slice(1),
            member.province,
            member.city,
            member.joined
        ]

        cells.forEach((value) => {
            const td = document.createElement('td')
            td.textContent = value
            row.appendChild(td)
        })

        // Delete button cell
        const action_td = document.createElement('td')
        const delete_btn = document.createElement('button')
        delete_btn.textContent = 'Delete'
        delete_btn.classList.add('delete-user-btn')
        delete_btn.dataset.id = member.id

        action_td.appendChild(delete_btn)
        row.appendChild(action_td)

        table_body.appendChild(row)
    })
}

// Event delegation — works for both server-rendered AND JS-rendered rows,
// since the listener is on table_body itself, not on individual buttons
table_body.addEventListener('click', function (event) {
    const button = event.target.closest('.delete-user-btn')
    if (!button) return

    const user_id = button.dataset.id
    const confirmed = confirm('Are you sure you want to delete this user? This cannot be undone.')

    if (!confirmed) return

    const form = document.createElement('form')
    form.method = 'POST'
    form.action = `${delete_user_url_base}/${user_id}`

    const csrf_input = document.createElement('input')
    csrf_input.type = 'hidden'
    csrf_input.name = '_token'
    csrf_input.value = csrf_token

    form.appendChild(csrf_input)
    document.body.appendChild(form)
    form.submit()
})