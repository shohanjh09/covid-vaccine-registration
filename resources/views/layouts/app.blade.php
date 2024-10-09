<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Add stylesheets, meta tags, etc. -->
</head>
<body>
<header>
    <!-- Site header, navigation, etc. -->
</header>

<main>
    @yield('content')  <!-- This is where individual views will be injected -->
</main>

<footer>
    <!-- Footer content -->
</footer>

<!-- Add JavaScript scripts here -->
</body>
</html>
