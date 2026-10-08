@include('layouts.app')
<!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Citizen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite([
        'resources/css/header.css', 
        'resources/css/citizens/sidebar-styles.css',
        'resources/css/citizens/user-profile.css'
    ])
    @if(Auth::user()->usertype == 'staff')
        @vite('resources/css/staffs/staff-sidebar.css')
    @elseif (Auth::user()->usertype == 'admin')
        @vite('resources/css/admin/admin-sidebar.css')
    @else
        @vite('resources/css/citizens/sidebar-styles.css')
    @endif
</head> 
<body> 
    <header>
        @include('includes.header')
        @if(Auth::user()->usertype == 'staff')
            @include('includes.staff-sidebar')
        @elseif (Auth::user()->usertype == 'citizen')
            @include('includes.sidebar')
        @elseif (Auth::user()->usertype == 'admin')
            @include('includes.admin-sidebar')
        @endif
    </header>

    <main class="main-content">
        <div class="content">
            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <div class="avatar-image" id="avatar-image-wrapper">
                            <img
                                src="{{ $user->image_path }}"
                                alt="Profile Avatar"
                                id="avatar-preview"
                                class="avatar-img"
                            >
                        </div>
                        <input type="file" name="avatar" id="avatar-input" accept="image/*" class="hidden" disabled  form="profile-form">
                        <p id="avatar-error" class="error-handler hidden"></p>

                        <div class="profile-status">
                            <span class="role-badge">{{ Auth::user()->usertype }}</span>
                        </div>
                    </div>
                    <h1 class="profile-title">
                        {{ $profile->username ?? Auth::user()->username }}'s Profile
                    </h1>
                </div>

                <div class="profile-content"> 
            <!-- Success Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form id="profile-form" action="{{ route('citizen.profile.update') }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">User Name</label>
                        <input type="text" id="username" name="username" 
                            value="{{ old('username', $user->username ?? '') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" 
                            value="{{ old('email', $user->email ?? '') }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-row">
                        <div class="form-group" style="position: relative; max-width: 600px;">
                            <label for="password">Current Password:</label>
                            <input type="password" id="current_password" name="current_password" class="form-control"
                            style="padding-right: 40px; padding: 12px; width: 100%; box-sizing: border-box; border-radius: 5px;" placeholder="Enter current password" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" id="password" name="password" 
                            placeholder="Leave blank to keep current password" readonly>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                            placeholder="Confirm new password" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="province-select">Province</label>
                        <select name="province" id="province-select" required>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ $user->province_id == $province->id ? 'selected' : '' }}>
                                    {{ $province->province }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="city-select">City</label>
                        <select name="city_id" id="city-select" required>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}"
                                    data-province="{{ $city->province_id }}"
                                    {{ $user->city_id == $city->id ? 'selected' : '' }}>
                                    {{ $city->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>


                <div class="form-actions">
                    <button type="button" id="edit-button" class="btn btn-secondary">Edit</button>
                    <button type="submit" id="save-button" class="btn btn-primary" disabled>Save</button>
                    <button type="button" id="cancel-button" class="btn btn-secondary" style="display: none;">Cancel</button>
                </div>
            </form>
        </div>
            </div>
        </div>
    </main>

    <script>
        $('#edit-button').on('click', function () {
            $('#profile-form input').removeAttr('readonly');
            $('#save-button').removeAttr('disabled');
        });
        const list_city_by_province = "{{ route('show.create-concern') }}"
    </script>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const editButton = document.getElementById('edit-button')
        const saveButton = document.getElementById('save-button')
        const cancelButton = document.getElementById('cancel-button')

        // Split into two groups, since selects and inputs need different locking mechanisms
        const textInputs = document.querySelectorAll('#profile-form input')
        const selectInputs = document.querySelectorAll('#profile-form select')

        const avatarWrapper = document.getElementById('avatar-image-wrapper')
        const avatarInput = document.getElementById('avatar-input')
        const avatarPreview = document.getElementById('avatar-preview')
        const avatarError = document.getElementById('avatar-error')

        const originalValues = {}
        let originalAvatarSrc = avatarPreview.src

        // Store original values for cancel/revert (covers both inputs and selects)
        textInputs.forEach(input => { originalValues[input.name] = input.value })
        selectInputs.forEach(select => { originalValues[select.name] = select.value })

        function enterEditMode () {
            textInputs.forEach(input => {
                input.removeAttribute('readonly')
            })

            selectInputs.forEach(select => {
                select.removeAttribute('disabled')
            })

            avatarInput.removeAttribute('disabled')
            avatarWrapper.classList.add('editable')

            editButton.style.display = 'none'
            saveButton.disabled = false
            cancelButton.style.display = 'inline-block'
        }

        const provinceSelect = document.getElementById('province-select')
        const citySelect = document.getElementById('city-select')

        let lastProvinceValue = provinceSelect.value // track so we know if it actually changed

        provinceSelect.addEventListener('change', function () {
            const newProvinceId = provinceSelect.value

            // Only reset/refetch if the province actually changed to a different value
            if (newProvinceId === lastProvinceValue) return
            lastProvinceValue = newProvinceId

            $.get(list_city_by_province, { province: newProvinceId }, function (values) {
                citySelect.innerHTML = ''

                values.city.forEach((city) => {
                    const option = document.createElement('option')
                    option.value = city.id
                    option.textContent = city.city
                    citySelect.appendChild(option)
                })

                // Force the user to pick a city again, since the old selection
                // may no longer belong to the newly selected province
                citySelect.value = ''
            })
        })

        function exitEditMode () {
        // Restore text inputs
        textInputs.forEach(input => {
            input.value = originalValues[input.name] || ''
            input.setAttribute('readonly', true)
        })

        // Restore province immediately
        provinceSelect.value = originalValues['province'] || ''
        provinceSelect.setAttribute('disabled', true)
        lastProvinceValue = provinceSelect.value

        // gets the current value of the city if the change is not saved.
        $.get(list_city_by_province, { province: originalValues['province'] }, function (values) {
            citySelect.innerHTML = ''

            values.city.forEach((city) => {
                const option = document.createElement('option')
                option.value = city.id
                option.textContent = city.city
                citySelect.appendChild(option)
            })

            citySelect.value = originalValues['city_id'] || ''
            citySelect.setAttribute('disabled', true)
        })

        // Revert avatar preview + clear any selected file
        avatarPreview.src = originalAvatarSrc
        avatarInput.value = ''
        avatarInput.setAttribute('disabled', true)
        avatarWrapper.classList.remove('editable')

        avatarError.textContent = ''
        avatarError.classList.add('hidden')

        editButton.style.display = 'inline-block'
        saveButton.disabled = true
        cancelButton.style.display = 'none'
    }

        // Start in locked state on page load
        selectInputs.forEach(select => select.setAttribute('disabled', true))

        editButton.addEventListener('click', enterEditMode)
        cancelButton.addEventListener('click', exitEditMode)

            // Clicking the avatar image (only while editable) opens the file picker
            avatarWrapper.addEventListener('click', function () {
                if (!avatarInput.disabled) {
                    avatarInput.click()
                }
            })

            // Validate + preview the chosen file
            avatarInput.addEventListener('change', function (event) {
                const file = event.target.files[0]

                if (!file) return

                if (!file.type.startsWith('image/')) {
                    avatarError.textContent = 'Please select a valid image file.'
                    avatarError.classList.remove('hidden')

                    // Reset the file input and preview, since the selection was invalid
                    avatarInput.value = ''
                    avatarPreview.src = originalAvatarSrc
                    return
                }

                // Valid image — clear any previous error and preview it
                avatarError.textContent = ''
                avatarError.classList.add('hidden')

                const reader = new FileReader()
                reader.onload = function (e) {
                    avatarPreview.src = e.target.result
                }
                reader.readAsDataURL(file)
            })
        })
    </script>

</body>
</html>
