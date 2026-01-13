<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'subdomain' => $this->subdomain,
            'tenantLogo' => $this->tenant_logo ? (str_starts_with($this->tenant_logo, 'logos/') ? asset('storage/' . $this->tenant_logo) : $this->tenant_logo) : null,
            'metaDescription' => $this->meta_description,
            // 'domain' => $this->domain, // Optional: Include if needed, but not in the requested example.
        ];
    }
}
