<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KayaGov?</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/css/header.css')
    @vite('resources/css/auth/staffs/upload-coe.css')
</head>
<body>

    <div class="body">

        <div class="form">
            <div class="form-header">
                <h1>KayaGov?</h1>
                <p class="header">Create a New Account</p>
                <p>or <a class="sign-in" href="{{ route('show.login') }}">sign in to an existing account</a></p>
            </div>

            <div class="form-card">
                <form id="form" action="{{ route('staff.register.coe') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="input-header">
                        <p>Kindly Upload Your Certificate of Employment</p>
                    </div>

                    <div class="form-handler-wrapper">
                        @if ($errors->any())
                            <ul class="form-handler">
                                <li class="error-header">Error Found</li>
                                @foreach ($errors->all() as $error)
                                    <li class="errors">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div id="upload-div" class="input">
                        <input class="file" type="file" name="file" id="file">
                        <p>Upload a file (PNG, JPG up to 10MB)</p>
                    </div>

                    <div class="uploaded-files-wrapper">
                        
                    </div>

                    <div class="error-handler">
                        <p id="file-label" class="file-handler hidden">Upload Your COE first before submitting.</p>
                    </div>

                    <div class="button-holder">
                        <button class="submit-button" type="submit">Create Account</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="image-section">
            <img src="{{ asset('images/register.png') }}" alt="">
        </div>
    </div>
    
    @vite('resources/js/upload-coe.js')
</body>
</html>