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
</head> 
<body> 
    <header>
        @include('includes.header')
        @include('includes.sidebar')
    </header>

    <main class="main-content">
        <div class="content">
            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <div class="avatar-image">
                            <svg class="avatar-placeholder" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                        </div>
                        <div class="profile-status">
                            <span class="role-badge">Citizen</span>
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

            <form id="profile-form" action="{{ route('citizen.profile.update') }}" method="POST">
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
                            <input type="password" id="password" name="password" class="form-control" style="padding-right: 40px; padding: 12px; width: 100%; box-sizing: border-box; border-radius: 5px;"
                                placeholder="Enter current password" readonly>
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
                    <label for="province">Province</label>
                    <select name="province" required>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->province }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <select name="city" required>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->city }}</option>
                        @endforeach
                    </select>
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
    </script>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('edit-button');
    const saveButton = document.getElementById('save-button');
    const cancelButton = document.getElementById('cancel-button');
    const formInputs = document.querySelectorAll('#profile-form input, #profile-form select');
    const originalValues = {};

    // Store original values
    formInputs.forEach(input => {
        originalValues[input.name] = input.value;
    });

    editButton.addEventListener('click', function() {
        // Enable form inputs
        formInputs.forEach(input => {
            input.removeAttribute('readonly');
            input.removeAttribute('disabled');
        });

        // Toggle buttons
        editButton.style.display = 'none';
        saveButton.disabled = false;
        cancelButton.style.display = 'inline-block';
    });

    cancelButton.addEventListener('click', function() {
        // Restore original values
        formInputs.forEach(input => {
            input.value = originalValues[input.name] || '';
        });

        // Disable form inputs
        formInputs.forEach(input => {
            input.setAttribute('readonly', true);
            if (input.tagName === 'SELECT') {
                input.setAttribute('disabled', true);
            }
        });

        // Toggle buttons
        editButton.style.display = 'inline-block';
        saveButton.disabled = true;
        cancelButton.style.display = 'none';
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('edit-button');
    const saveButton = document.getElementById('save-button');
    const cancelButton = document.getElementById('cancel-button');
    const formInputs = document.querySelectorAll('#profile-form input, #profile-form select');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const originalValues = {};

    // Store original values
    formInputs.forEach(input => {
        originalValues[input.name] = input.value;
    });

    // Make selects readonly by disabling pointer events initially
    provinceSelect.style.pointerEvents = 'none';
    provinceSelect.style.backgroundColor = '#e9ecef';
    provinceSelect.tabIndex = -1;

    citySelect.style.pointerEvents = 'none';
    citySelect.style.backgroundColor = '#e9ecef';
    citySelect.tabIndex = -1;

    editButton.addEventListener('click', function() {
        // Enable inputs and selects
        formInputs.forEach(input => {
            input.removeAttribute('readonly');
            input.removeAttribute('disabled');
        });

        // Enable pointer events and reset styles on selects
        provinceSelect.style.pointerEvents = '';
        provinceSelect.style.backgroundColor = '';
        provinceSelect.tabIndex = 0;

        citySelect.style.pointerEvents = '';
        citySelect.style.backgroundColor = '';
        citySelect.tabIndex = 0;

        // Toggle buttons
        editButton.style.display = 'none';
        saveButton.disabled = false;
        cancelButton.style.display = 'inline-block';
    });

    cancelButton.addEventListener('click', function() {
        // Restore original values
        formInputs.forEach(input => {
            input.value = originalValues[input.name] || '';
        });

        // Disable inputs again
        formInputs.forEach(input => {
            input.setAttribute('readonly', true);
            if (input.tagName === 'SELECT') {
                // Disable pointer events again on selects
                input.style.pointerEvents = 'none';
                input.style.backgroundColor = '#e9ecef';
                input.tabIndex = -1;
            }
        });

        // Toggle buttons
        editButton.style.display = 'inline-block';
        saveButton.disabled = true;
        cancelButton.style.display = 'none';
    });
});
    </script>



</body>
</html>
