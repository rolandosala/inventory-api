<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->string('asset_tag')->unique();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers')
                ->nullOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->foreignId('location_id')
                ->nullable()
                ->constrained('locations')
                ->nullOnDelete();

            $table->string('property_number')->nullable()->unique();

            $table->string('item_name');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable()->unique();

            $table->text('specifications')->nullable();

            $table->integer('quantity')->default(1);

            $table->decimal('unit_cost', 15, 2)->nullable();

            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();

            $table->enum('status', [
                'available',
                'assigned',
                'under_maintenance',
                'lost',
                'disposed',
                'return to supply',
                'for checking'
            ])->default('available');

            $table->enum('condition', [
                'new',
                'good',
                'fair',
                'poor',
                'damaged'
            ])->default('new');

            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
