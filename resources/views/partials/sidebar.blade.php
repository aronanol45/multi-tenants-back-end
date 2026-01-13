<div class="sidebar">
    <h2>Businesscom - Boutiques</h2>
    <a href="{{ route('tenants.index') }}" class="{{ request()->routeIs('tenants.*') ? 'active' : '' }}">Tenants</a>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
</div>
