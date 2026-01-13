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
