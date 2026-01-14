<div class="sidebar">
    <h2>BSC - B2Bshop</h2>
    <a href="{{ route('tenants.index') }}" class="{{ request()->routeIs('tenants.*') ? 'active' : '' }}">Tenants</a>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
    @if(in_array(auth()->user()->role, ['super-admin', 'admin']))
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a>
    @endif
    
    <div style="margin-top: 2rem; border-top: 1px solid #374151; padding-top: 1rem;">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="background: none; border: none; color: #d1d5db; cursor: pointer; padding: 0.75rem 0.5rem; text-align: left; width: 100%; font-size: 1rem; font-family: inherit;">
                Logout
            </button>
        </form>
    </div>
</div>
