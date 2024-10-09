<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Vaccine Registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Vite to load assets -->
    <style>
        /* Custom color palette */
        body {
            background-color: #f8f9fa; /* Light grey background */
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            background-color: #F26D3E; /* Menu color */
            padding: 10px;
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #77C045; /* Green color for buttons */
            border-color: #77C045;
        }
        .btn-primary:hover {
            background-color: #66a43d; /* Darker green for hover */
        }
        .card-header {
            background-color: #77C045; /* Green header color for forms */
            color: white;
            text-align: center;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for a modern look */
            border-radius: 10px;
            margin-bottom: 20px;
            border: none;
        }
        /* Form Spacing */
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            padding: 10px;
            border-radius: 5px;
        }

        /* Footer Styling */
        footer {
            background-color: #F26D3E; /* Footer matches the menu */
            padding: 15px;
            color: white;
            text-align: center;
            margin-top: auto; /* Push footer to bottom */
            width: 100%;
        }

        /* Container Flexbox to ensure content spacing */
        .container {
            flex: 1;
        }
    </style>
</head>
<body>
<!-- Custom Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">COVID-19 Vaccine</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('search') }}">Check Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content Area -->
<div class="container mt-5">
    @yield('content')
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 COVID-19 Vaccine Registration. All rights reserved.</p>
</footer>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
