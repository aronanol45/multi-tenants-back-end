@extends('layouts.app')

@section('content')
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
        <a href="{{ route('tenants.index') }}" style="margin-left: 1rem; color: #6b7280; text-decoration: none;">Cancel</a>
    </form>
@endsection
