@extends('layouts.app')

@section('content')
    <h1>Edit Tenant: {{ $tenant->name }}</h1>

    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tenants.update', $tenant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div>
            <label>Subdomain:</label>
            <input type="text" name="subdomain" required value="{{ old('subdomain', $tenant->subdomain) }}">
        </div>
        <div>
            <label>Domain:</label>
            <input type="text" name="domain" required value="{{ old('domain', $tenant->domain) }}">
        </div>
        <div>
            <label>Name:</label>
            <input type="text" name="name" required value="{{ old('name', $tenant->name) }}">
        </div>
        <div>
            <label>Tenant Logo:</label>
            @if($tenant->tenant_logo)
                <div style="margin-bottom: 0.5rem;">
                    <img src="{{ Str::startsWith($tenant->tenant_logo, 'logos/') ? asset('storage/' . $tenant->tenant_logo) : $tenant->tenant_logo }}" alt="Current Logo" width="100" style="border-radius: 4px;">
                    <p style="font-size: 0.875rem; color: #6b7280;">Current Logo</p>
                </div>
            @endif
            <input type="file" name="tenant_logo">
        </div>
        
        <h3>Meta Description</h3>
        <div>
            <label>English:</label>
            <textarea name="meta_description_en" rows="3">{{ old('meta_description_en', $tenant->meta_description['en'] ?? '') }}</textarea>
        </div>
        <div>
            <label>German:</label>
            <textarea name="meta_description_de" rows="3">{{ old('meta_description_de', $tenant->meta_description['de'] ?? '') }}</textarea>
        </div>
        <div>
            <label>French:</label>
            <textarea name="meta_description_fr" rows="3">{{ old('meta_description_fr', $tenant->meta_description['fr'] ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn-primary">Update Tenant</button>
        <a href="{{ route('tenants.index') }}" style="margin-left: 1rem; color: #6b7280; text-decoration: none;">Cancel</a>
    </form>
@endsection
