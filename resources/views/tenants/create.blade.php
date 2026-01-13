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
            max-width: 900px;
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
        button.btn-primary {
            background-color: #2563eb;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        button.btn-primary:hover {
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
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Businesscom - Boutiques</h2>
    <a href="{{ route('tenants.create') }}" class="active">Tenants</a>
    <!-- Add more links here later -->
</div>

<div class="main-content">
    <div class="container">
        <h1>Create A New Tenant</h1>

        @if(session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tenants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label>Subdomain:</label>
                <input type="text" name="subdomain" required placeholder="e.g. acme">
            </div>
            <div>
                <label>Domain:</label>
                <input type="text" name="domain" required placeholder="e.g. acme.com">
            </div>
            <div>
                <label>Name:</label>
                <input type="text" name="name" required placeholder="e.g. Acme Corp">
            </div>
            <div>
                <label>Tenant Logo:</label>
                <input type="file" name="tenant_logo">
            </div>
            
            <h3>Meta Description</h3>
            <div>
                <label>English:</label>
                <textarea name="meta_description_en" rows="3"></textarea>
            </div>
            <div>
                <label>German:</label>
                <textarea name="meta_description_de" rows="3"></textarea>
            </div>
            <div>
                <label>French:</label>
                <textarea name="meta_description_fr" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-primary">Add Tenant</button>
        </form>

        <hr>

        <h3>Existing Tenants</h3>
        <table border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Domain</th>
                    <th>Subdomain</th>
                    <th>Logo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tenants as $tenant)
                    <tr>
                        <td>{{ $tenant->id }}</td>
                        <td>{{ $tenant->name }}</td>
                        <td>
                            @if(App::environment('local'))
                                <a href="http://{{ $tenant->subdomain }}.companynameapi.local" target="_blank" style="color: #2563eb; text-decoration: none;">{{ $tenant->domain }} (Dev)</a>
                            @else
                                <a href="http://{{ $tenant->domain }}" target="_blank" style="color: #2563eb; text-decoration: none;">{{ $tenant->domain }}</a>
                            @endif
                        </td>
                        <td>{{ $tenant->subdomain }}</td>
                        <td>
                            @if($tenant->tenant_logo)
                                <img src="{{ Str::startsWith($tenant->tenant_logo, 'logos/') ? asset('storage/' . $tenant->tenant_logo) : $tenant->tenant_logo }}" alt="Logo" width="40" style="border-radius: 4px;">
                            @else
                                <span style="color: #9ca3af;">No Logo</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
