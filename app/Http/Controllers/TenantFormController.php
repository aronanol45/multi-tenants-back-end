<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Str;

class TenantFormController extends Controller
{
    public function index()
    {
        $tenants = Tenant::latest()->get();
        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('tenants.create');
    }

    public function store(Request $request)
    {
        if ($request->has('subdomain')) {
            $request->merge(['subdomain' => Str::slug($request->input('subdomain'))]);
        }
        
        $request->validate([
            'subdomain' => 'required|unique:tenants,subdomain',
            'domain' => 'required|unique:tenants,domain',
            'name' => 'required|string|max:255',
            'tenant_logo' => 'nullable|image|max:2048',
            'meta_description_en' => 'nullable|string',
            'meta_description_de' => 'nullable|string',
            'meta_description_fr' => 'nullable|string',
        ]);

        $data = $request->only(['subdomain', 'domain', 'name']);

        // Construct meta_description JSON
        $metaDescription = [];
        if ($request->filled('meta_description_en')) $metaDescription['en'] = $request->input('meta_description_en');
        if ($request->filled('meta_description_de')) $metaDescription['de'] = $request->input('meta_description_de');
        if ($request->filled('meta_description_fr')) $metaDescription['fr'] = $request->input('meta_description_fr');
        
        $data['meta_description'] = !empty($metaDescription) ? $metaDescription : null;

        if ($request->hasFile('tenant_logo')) {
            $data['tenant_logo'] = $request->file('tenant_logo')->store('logos', 'public');
        }

        Tenant::create($data);



        return redirect()->route('tenants.index')->with('success', 'Tenant added successfully!');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully!');
    }

    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    public function show(Tenant $tenant)
    {
        return view('tenants.show', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        if ($request->has('subdomain')) {
            $request->merge(['subdomain' => Str::slug($request->input('subdomain'))]);
        }

        $request->validate([
            'subdomain' => 'required|unique:tenants,subdomain,' . $tenant->id,
            'domain' => 'required|unique:tenants,domain,' . $tenant->id,
            'name' => 'required|string|max:255',
            'tenant_logo' => 'nullable|image|max:2048',
            'meta_description_en' => 'nullable|string',
            'meta_description_de' => 'nullable|string',
            'meta_description_fr' => 'nullable|string',
        ]);

        $data = $request->only(['subdomain', 'domain', 'name']);

        // Construct meta_description JSON
        $metaDescription = [];
        if ($request->filled('meta_description_en')) $metaDescription['en'] = $request->input('meta_description_en');
        if ($request->filled('meta_description_de')) $metaDescription['de'] = $request->input('meta_description_de');
        if ($request->filled('meta_description_fr')) $metaDescription['fr'] = $request->input('meta_description_fr');
        
        $data['meta_description'] = !empty($metaDescription) ? $metaDescription : null;

        if ($request->hasFile('tenant_logo')) {
            $data['tenant_logo'] = $request->file('tenant_logo')->store('logos', 'public');
        }

        $tenant->update($data);



        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully!');
    }
}
