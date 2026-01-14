<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreignId('delivery_address_id')->nullable()->constrained('delivery_addresses')->nullOnDelete();
            $table->foreignId('payment_address_id')->nullable()->constrained('payment_addresses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['delivery_address_id']);
            $table->dropForeign(['payment_address_id']);
            $table->dropColumn(['delivery_address_id', 'payment_address_id']);
        });
    }
};
