<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/header.css')
</head>
<body>
    <header>
        @include('includes.header')
        @include('includes.navbar')
    </header>
    <h1>Home Page</h1>
</body>
</html>