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
            <label class="block text-sm font-medium text-gray-700">Subdomain:</label>
            <div style="display: flex; align-items: center; max-width: 300px;">
                <input type="text" name="subdomain" required placeholder="e.g. acme" style="flex: 1; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                <span style="display: inline-flex; align-items: center; padding: 0.5rem 0.75rem; background-color: #f3f4f6; border: 1px solid #d1d5db; border-left: 0; border-top-right-radius: 4px; border-bottom-right-radius: 4px; color: #6b7280; height: 38px; box-sizing: border-box;">
                    .{{ config('app.frontend_root_domain') }}
                </span>
            </div>
        </div>
        <div>
            <label>Custom Domain (Optional):</label>
            <input type="text" name="custom_domain" placeholder="e.g. pfeffer.ch" style="width: 100%;">
            <small style="color: #6b7280; display: block; margin-top: 4px;">Enter a custom domain if the tenant has one (e.g. pfeffer.ch)</small>
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
