<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('listing_type', 10)->default('sale')->after('title');
            $table->bigInteger('deposit_amount')->nullable()->after('price');
            $table->bigInteger('rent_amount')->nullable()->after('deposit_amount');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['listing_type', 'deposit_amount', 'rent_amount']);
        });
    }
};
