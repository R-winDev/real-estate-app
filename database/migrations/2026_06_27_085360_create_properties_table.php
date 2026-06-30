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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            $table->decimal('area_total', 10, 2)->nullable();
            $table->decimal('area_useful', 10, 2)->nullable();
            $table->decimal('land_length', 10, 2)->nullable();
            $table->decimal('land_width', 10, 2)->nullable();
            $table->decimal('land_area', 10, 2)->nullable();
            $table->smallInteger('year_built')->nullable();
            $table->enum('orientation', ['north', 'south', 'east', 'west'])->nullable();

            $table->smallInteger('bedrooms')->nullable();
            $table->smallInteger('bathrooms')->nullable();
            $table->smallInteger('floor')->nullable();
            $table->smallInteger('total_floors')->nullable();
            $table->smallInteger('units_count')->nullable();

            $table->boolean('has_parking')->default(false);
            $table->smallInteger('parking_count')->default(0);
            $table->boolean('has_elevator')->default(false);
            $table->boolean('has_storage')->default(false);
            $table->boolean('has_balcony')->default(false);
            $table->boolean('has_garden')->default(false);

            $table->foreignId('status_id')->nullable()->constrained('property_statuses');
            $table->bigInteger('price')->nullable()->comment('rial');
            $table->boolean('is_sold')->default(false);
            $table->string('address_fa')->nullable();

            $table->foreignId('type_id')->nullable()->constrained('property_types');
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->foreignId('owner_id')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
