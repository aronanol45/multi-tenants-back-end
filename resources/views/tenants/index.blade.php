@extends('layouts.app')

@section('content')
    <div class="header-actions">
        <h1>Existing Tenants</h1>
        <a href="{{ route('tenants.create') }}" class="btn-primary">Create New Tenant</a>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <table border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>BSC url</th>
                <th>Custom URL</th>
                <th>Logo</th>
                <th>Creation Date</th>
                <th>Last Edit</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tenants as $tenant)
                <tr>
                    <td>
                        <a href="{{ route('tenants.show', $tenant->id) }}" style="font-weight: 500; color: #2563eb; text-decoration: none;">
                            {{ $tenant->id }}
                        </a>
                    </td>
                    <td>{{ $tenant->name }}</td>
                    <td>
                        @php
                            $subdomainUrl = App::environment('local') 
                                ? "http://{$tenant->subdomain}.companynameapi.local" 
                                : "http://{$tenant->subdomain}." . config('app.frontend_root_domain');
                            $subdomainDisplay = $tenant->subdomain . '.' . config('app.frontend_root_domain');
                        @endphp
                        <a href="{{ $subdomainUrl }}" target="_blank" style="color: #2563eb; text-decoration: none;">
                            {{ $subdomainDisplay }}
                        </a>
                    </td>
                    <td>
                        @if($tenant->custom_domain)
                            <a href="http://{{ $tenant->custom_domain }}" target="_blank" style="color: #2563eb; text-decoration: none;">
                                {{ $tenant->custom_domain }}
                            </a>
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($tenant->tenant_logo)
                            <img src="{{ Str::startsWith($tenant->tenant_logo, 'logos/') ? asset('storage/' . $tenant->tenant_logo) : $tenant->tenant_logo }}" alt="Logo" width="40" style="border-radius: 4px;">
                        @else
                            <span style="color: #9ca3af;">No Logo</span>
                        @endif
                    </td>
                    <td>{{ $tenant->created_at->format('d/m/Y') }}</td>
                    <td>{{ $tenant->updated_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('tenants.show', $tenant->id) }}" style="color: #2563eb; margin-right: 0.5rem; text-decoration: none; font-size: 0.875rem;">View</a>
                        <a href="{{ route('tenants.edit', $tenant->id) }}" style="color: #2563eb; margin-right: 0.5rem; text-decoration: none; font-size: 0.875rem;">Edit</a>
                        <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
