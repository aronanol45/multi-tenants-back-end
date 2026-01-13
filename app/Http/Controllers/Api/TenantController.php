<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\TenantResource;

class TenantController extends Controller
{
    // GET /api/tenants
    public function index()
    {
        return TenantResource::collection(Tenant::all());
    }

        // POST /api/tenants
    public function store(Request $request)
    {
        // Note: The frontend sends 'tenantLogo' and 'metaDescription' but typically API expects snake_case inputs 
        // or we map them here. For consistency with the Resource, let's accept camelCase if possible 
        // or expect the frontend to send snake_case payload? 
        // The user showed the frontend *data placeholder*, which suggests the structure they want *back*.
        // It's ambiguous what they send *to* the API. I will assume standard Laravel snake_case input for now 
        // OR map the keys manually if they send the exact JSON structure.
        // Let's support the snake_case keys for the database but check inputs.
        
        $validator = Validator::make($request->all(), [
            'subdomain' => 'required|unique:tenants,subdomain',
            // 'domain' => 'required|unique:tenants,domain', // Domain might be optional or auto-generated? kept it required as per old code
            'domain' => 'required|unique:tenants,domain',
            'name' => 'required|string|max:255',
            'tenant_logo' => 'nullable|string', // Changed to string as the example data has paths, not file uploads? 
            'meta_description' => 'nullable|array',
        ]);

        // Support for transforming camelCase inputs if sent (e.g. tenantLogo -> tenant_logo) if needed in future
        // For now sticking to direct validation.

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle logo upload if it's a file
        if ($request->hasFile('tenant_logo')) {
            $data['tenant_logo'] = $request->file('tenant_logo')->store('logos', 'public');
        } 
        // If it's a string path (from the example JSON), it will be passed through validated() if rule allows string.
        
        $tenant = Tenant::create($data);

        return new TenantResource($tenant);
    }
}
