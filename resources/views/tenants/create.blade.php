<form action="{{ route('tenants.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Subdomain:</label>
        <input type="text" name="subdomain" required>
    </div>
    <div>
        <label>Domain:</label>
        <input type="text" name="domain" required>
    </div>
    <div>
        <label>Name:</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Tenant Logo:</label>
        <input type="file" name="tenant_logo">
    </div>
    
    <h3>Meta Description</h3>
    <div>
        <label>English:</label>
        <textarea name="meta_description_en"></textarea>
    </div>
    <div>
        <label>German:</label>
        <textarea name="meta_description_de"></textarea>
    </div>
    <div>
        <label>French:</label>
        <textarea name="meta_description_fr"></textarea>
    </div>
    <button type="submit">Add Tenant</button>
</form>

<hr>

<h3>Existing Tenants</h3>
<table border="1" cellpadding="10" cellspacing="0">
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
                        <a href="http://{{ $tenant->subdomain }}.companynameapi.local" target="_blank">{{ $tenant->domain }} (Dev)</a>
                    @else
                        <a href="http://{{ $tenant->domain }}" target="_blank">{{ $tenant->domain }}</a>
                    @endif
                </td>
                <td>{{ $tenant->subdomain }}</td>
                <td>
                    @if($tenant->tenant_logo)
                        <img src="{{ Str::startsWith($tenant->tenant_logo, 'logos/') ? asset('storage/' . $tenant->tenant_logo) : $tenant->tenant_logo }}" alt="Logo" width="50">
                    @else
                        No Logo
                    @endif
                </td>
                <td>
                    <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red;">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
