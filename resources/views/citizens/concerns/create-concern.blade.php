<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KayaGov?</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/3f4dbee37e.js" crossorigin="anonymous"></script>
    @vite('resources/css/header.css')
    @vite('resources/css/citizens/create-concern-dropdown.css')
    @vite('resources/css/citizens/create-concern.css')
    @vite('resources/css/citizens/sidebar-styles.css')
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.sidebar')
    </header>

    <section class="body">
        <div class="back-page">
            <a href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i>Back</a>
        </div>

        <section class="section-header">
            <h1>Report New Concern</h1>
            <p>Provide details about the issue you'd like to report to your local government.</p>
        </section>

        <section class="section-body">
            <div class="form-header">
                <p>Concern Details</p>
                <div class="line"></div>
            </div>

            <div class="form-body">
                <form action="{{ route('store.create') }}" id="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input">
                        <label class="input-label" for="title">Title <span id="title-span" class="required">*</span></label>
                        <input type="text" id="title" name="title" placeholder="Brief title describing the issue...">
                    </div>

                    <div class="input">
                        <label class="input-label" for="description">Description <span id="desc-span" class="required">*</span></label>
                        <textarea name="description" id="description" placeholder="Provide detailed information about the issue..."></textarea>
                    </div>

                    <div class="input">
                        <label class="input-label" for="category">Category <span id="category-span" class="required">*</span></label>
                        <select name="category" id="category">
                            <option disabled selected value="">Select the Category of the Issue</option>
                            <option value="Roads">Roads</option>
                            <option value="Street Light">Street Light</option>
                            <option value="Sidewalk and Pedestrian">Sidewalk and Pedestrian</option>
                            <option value="Garbage Collection and Waste Disposal">Garbage Collection and Waste Disposal</option>
                            <option value="Traffic Congestion">Traffic Congestion</option>
                            <option value="Government Aid Request">Government Aid Request</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="input">
                        <label class="input-label" for="city">City Located <span id="city-span" class="required">*</span></label>
                        <div class="selector-wrapper">
                            <div class="selector">
                                <span class="selector_text">Select a City</span>
                                <span><i id="arrow" class="fa-solid fa-angle-down"></i></span>
                            </div>

                            <div class="options">
                                <input type="hidden" id="city" class="input" name="city_id">
                                <div class="search-wrapper">
                                    <input type="text" class="search-input" placeholder="Search a City...">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="file" name="file[]" class="file" id="file-input" multiple hidden>
                    <div class="input">
                        <label class="input-label" for="">Photo Evidence (Optional)</label>
                        <div class="upload-wrapper">
                            <i class="fa-solid fa-upload"></i>
                            <span>Upload a file (PNG, JPEG up to 10mb)</span>
                        </div>
                    </div>

                    <div class="uploaded-image-wrapper input">
                        <label class="image-label hidden" for="">Uploaded Images</label>
                    </div>

                    <div class="button-wrapper">
                        <a href=""><button class="cancel">Cancel</button></a>
                        <button type="submit" class="submit">Submit Concern</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    

    <script>
        const show_city = "{{ route('show.create-concern') }}"
        const search_city = "{{ route('search.create-concern') }}"
    </script>
    
    @vite('resources/js/create-concern/city-show.js')
    @vite('resources/js/create-concern/upload-image.js')
    @vite('resources/js/create-concern/error-checker.js')
</body>
</html>