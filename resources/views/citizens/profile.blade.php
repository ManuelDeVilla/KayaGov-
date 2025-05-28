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
                            {{ ($profile->first_name ?? '') . ' ' . ($profile->last_name ?? '') }}
                        </h1>
                </div>

                <div class="profile-content"> 
                    <form id="profile-form" action="{{ route('citizen.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="firstName" value="{{ old('firstName', $profile->first_name ?? '') }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="lastName" value="{{ old('lastName', $profile->last_name ?? '') }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $profile->email ?? '') }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $profile->phone ?? '') }}" readonly>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" id="edit-button" class="btn btn-secondary">Edit</button>
                            <button type="submit" id="save-button" class="btn btn-primary" disabled>Save</button>
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
</body>
</html>
