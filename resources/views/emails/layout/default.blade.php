<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vaccination Reminder')</title>
    <style>
        /* Custom email styles */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #F26D3E;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            color: #777;
            font-size: 12px;
            margin-top: 20px;
        }
        .button {
            background-color: #77C045;
            color: white;
            padding: 10px 20px;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #66a43d;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        COVID-19 Vaccine Registration
    </div>
    <div class="content">
        @yield('content')
    </div>
    <div class="footer">
        &copy; 2024 COVID-19 Vaccine Registration. All rights reserved.
    </div>
</div>
</body>
</html>
