<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = [
            [
                "name" => "Acme Corp",
                "subdomain" => "acme",
                "domain" => "acme.glaive.ch", // Added domain as it is required and unique
                "tenant_logo" => "/images/tenants/qualipet.png",
                "meta_description" => [
                    "en" => "Welcome to Acme Corp. Discover our exclusive range of products tailored just for you.",
                    "de" => "Willkommen bei Acme Corp. Entdecken Sie unser exklusives Produktsortiment.",
                    "fr" => "Bienvenue chez Acme Corp. Découvrez notre gamme exclusive de produits."
                ]
            ],
            [
                "name" => "Kurtic Corp",
                "subdomain" => "kurtic",
                "domain" => "kurtic.glaive.ch",
                "tenant_logo" => "/images/tenants/kurtic-logo.png",
                "meta_description" => [
                    "en" => "Kurtic Corp brings you the finest quality items. Shop the best of Kurtic Corp today.",
                    "de" => "Kurtic Corp bringt Ihnen Artikel von höchster Qualität. Kaufen Sie noch heute das Beste von Kurtic Corp.",
                    "fr" => "Kurtic Corp vous propose des articles de la meilleure qualité. Achetez le meilleur de Kurtic Corp dès aujourd'hui."
                ]
            ],
            [
                "name" => "Beta LLC",
                "subdomain" => "beta",
                "domain" => "beta.glaive.ch",
                "tenant_logo" => "/images/tenants/BSC_Logo_2023_white.png",
                "meta_description" => [
                    "en" => "Experience innovation with Beta LLC. We provide top-tier solutions for modern needs.",
                    "de" => "Erleben Sie Innovation mit Beta LLC. Wir bieten erstklassige Lösungen für moderne Anforderungen.",
                    "fr" => "Découvrez l'innovation avec Beta LLC. Nous proposons des solutions de haut niveau pour les besoins modernes."
                ]
            ],
            [
                "name" => "Gamma Inc",
                "subdomain" => "gamma",
                "domain" => "gamma.glaive.ch",
                "tenant_logo" => "/images/tenants/BSC_Logo_2023_white.png",
                "meta_description" => [
                    "en" => "Gamma Inc offers premium services and products. Explore what makes Gamma Inc unique.",
                    "de" => "Gamma Inc bietet erstklassige Dienstleistungen und Produkte. Entdecken Sie, was Gamma Inc einzigartig macht.",
                    "fr" => "Gamma Inc propose des services et produits haut de gamme. Découvrez ce qui rend Gamma Inc unique."
                ]
            ],
            [
                "name" => "Locher Shop",
                "subdomain" => "locher",
                "domain" => "locher.glaive.ch",
                "tenant_logo" => "/images/tenants/locher-logo.png",
                "meta_description" => [
                    "en" => "Your one-stop shop at Locher Shop. Quality and satisfaction guaranteed.",
                    "de" => "Ihr One-Stop-Shop im Locher Shop. Qualität und Zufriedenheit garantiert.",
                    "fr" => "Votre guichet unique chez Locher Shop. Qualité et satisfaction garanties."
                ]
            ]
        ];

        foreach ($tenants as $tenant) {
            \App\Models\Tenant::updateOrCreate(
                ['subdomain' => $tenant['subdomain']], // Use subdomain as unique key to prevent duplicates
                $tenant
            );
        }
    }
}
