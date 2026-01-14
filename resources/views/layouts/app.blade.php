<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tenants</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            line-height: 1.5;
            margin: 0;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #1f2937; /* Dark gray */
            color: white;
            padding: 2rem 1rem;
            flex-shrink: 0;
        }
        .sidebar h2 {
            margin-top: 0;
            margin-bottom: 2rem;
            font-size: 1.25rem;
            padding-left: 0.5rem;
        }
        .sidebar a {
            display: block;
            color: #d1d5db;
            text-decoration: none;
            padding: 0.75rem 0.5rem;
            border-radius: 4px;
            margin-bottom: 0.5rem;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #374151;
            color: white;
        }
        .main-content {
            flex-grow: 1;
            padding: 2rem;
            overflow-y: auto;
        }
        .container {
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        h1, h3 {
            margin-top: 0;
            color: #111827;
        }
        form > div {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            box-sizing: border-box; 
        }
        button.btn-primary, a.btn-primary {
            background-color: #2563eb;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
        }
        button.btn-primary:hover, a.btn-primary:hover {
            background-color: #1d4ed8;
        }
        hr {
            margin: 2rem 0;
            border: 0;
            border-top: 1px solid #e5e7eb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
            margin-top: 1rem;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f9fafb;
        }
        .text-red {
            color: #ef4444;
            background: none;
            padding: 0;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }
        .text-red:hover {
            color: #dc2626;
            text-decoration: underline;
        }
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>

@include('partials.sidebar')

<div class="main-content">
    <section class="container">
        @yield('content')
    </section>
</div>

</body>
</html>
