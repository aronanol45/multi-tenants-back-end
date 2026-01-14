@extends('layouts.app')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <h1 style="margin-bottom: 2rem;">Create New User</h1>

        <form action="{{ route('users.store') }}" method="POST" style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div style="color: red; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div style="color: red; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="">Select Role...</option>
                    <option value="super-admin" {{ old('role') == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                </select>
                @error('role')
                    <div style="color: red; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="8">
                @error('password')
                    <div style="color: red; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn-primary">Create User</button>
                <a href="{{ route('users.index') }}" style="margin-left: 1rem; color: #6b7280; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
