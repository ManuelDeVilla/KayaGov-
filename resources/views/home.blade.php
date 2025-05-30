<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KayaGov: Empowering Citizens</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800">

    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-blue-600">KayaGov?</span>
            </div>
            <div>
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 mr-4">Log in</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Sign up</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-blue-50 to-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900">
                Bridging Citizens and Government
            </h1>
            <p class="mt-4 text-lg text-gray-600">
                KayaGov is your platform for transparent communication with local authorities.
            </p>
            <div class="mt-6">
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-3 rounded-md text-lg hover:bg-blue-700">Get Started</a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">How KayaGov Works</h2>
            <p class="mt-4 text-lg text-gray-600">A seamless process to address your concerns</p>
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <x-lucide-alert-circle class="w-12 h-12 text-blue-600 mx-auto" />
                    <h3 class="mt-4 text-xl font-semibold">Report</h3>
                    <p class="mt-2 text-gray-600">Submit issues with details and photos.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <x-lucide-bell class="w-12 h-12 text-blue-600 mx-auto" />
                    <h3 class="mt-4 text-xl font-semibold">Track</h3>
                    <p class="mt-2 text-gray-600">Monitor the status of your reports.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <x-lucide-check-circle class="w-12 h-12 text-blue-600 mx-auto" />
                    <h3 class="mt-4 text-xl font-semibold">Resolve</h3>
                    <p class="mt-2 text-gray-600">Receive resolutions and provide feedback.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Key Features</h2>
            <p class="mt-4 text-lg text-gray-600">Empowering tools for effective governance</p>
            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    ['icon' => 'upload', 'title' => 'Easy Submissions', 'description' => 'Report issues effortlessly.'],
                    ['icon' => 'users', 'title' => 'Department Routing', 'description' => 'Automatic concern assignment.'],
                    ['icon' => 'bell', 'title' => 'Status Updates', 'description' => 'Real-time notifications.'],
                    ['icon' => 'camera', 'title' => 'Photo Evidence', 'description' => 'Attach images for clarity.'],
                    ['icon' => 'bar-chart', 'title' => 'Analytics Dashboard', 'description' => 'Insights into community issues.'],
                    ['icon' => 'shield', 'title' => 'Data Security', 'description' => 'Your information is protected.'],
                ] as $feature)
                    <div class="bg-gray-50 p-6 rounded-lg shadow hover:shadow-lg transition">
                        <x-lucide-{{ $feature['icon'] }} class="w-10 h-10 text-blue-600 mx-auto" />
                        <h3 class="mt-4 text-xl font-semibold">{{ $feature['title'] }}</h3>
                        <p class="mt-2 text-gray-600">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

   <!-- Meet the Developers -->
<section class="py-16 bg-blue-50">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-extrabold text-gray-900">Meet the Developers</h2>
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['name' => 'Manuel De Villa', 'image' => 'manuel.jpg'],
                ['name' => 'Anna Lea Dagos', 'image' => 'anna.jpg'],
                ['name' => 'Franchielle Palencia', 'image' => 'nikki.jpg'],
            ] as $dev)
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                    <img src="{{ asset('images/developers/' . $dev['image']) }}" alt="{{ $dev['name'] }}" class="w-24 h-24 mx-auto rounded-full object-cover border-4 border-blue-100">
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $dev['name'] }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</section>


    <!-- Call to Action -->
    <section class="py-16 bg-blue-600 text-white text-center">
        <h2 class="text-3xl font-extrabold">Join KayaGov Today</h2>
        <p class="mt-4 text-lg">Be part of the change in your community.</p>
        <div class="mt-6">
            <a href="{{ route('register') }}" class="bg-white text-blue-600 px-6 py-3 rounded-md text-lg hover:bg-gray-100">Sign Up Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between">
            <div>
                <h3 class="text-white text-xl font-bold">KayaGov</h3>
                <p class="mt-2">Empowering citizens through transparent governance.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <h4 class="text-white font-semibold">Contact Us</h4>
                <p>Email: info@kayagov.example</p>
                <p>Phone: (123) 456-7890</p>
            </div>
        </div>
        <div class="mt-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} KayaGov. All rights reserved.
        </div>
    </footer>

</body>
</html>
