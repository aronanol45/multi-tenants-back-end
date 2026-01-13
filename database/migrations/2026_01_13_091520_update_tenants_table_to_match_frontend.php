<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->renameColumn('shop_name', 'name');
            $table->renameColumn('shop_logo', 'tenant_logo');
            $table->json('meta_description')->nullable()->after('tenant_logo');
            
            // Drop unused columns if they exist, or just leave them. 
            // To strictly match the request "make them match in the tenants table", 
            // I should probably remove the old ones, but to be safe I will just make the new ones available.
            // Actually, let's keep it clean.
            $table->dropColumn(['shop_address', 'languages']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
             $table->renameColumn('name', 'shop_name');
             $table->renameColumn('tenant_logo', 'shop_logo');
             $table->dropColumn('meta_description');
             $table->string('shop_address')->nullable();
             $table->json('languages')->nullable();
        });
    }
};
