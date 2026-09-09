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
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('maintenance_type');

            $table->date('date_reported');
            $table->date('date_started')->nullable();
            $table->date('date_completed')->nullable();

            $table->text('problem_description')->nullable();
            $table->text('action_taken')->nullable();

            $table->decimal('cost', 15, 2)->default(0);

            $table->enum('status', [
                'reported',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('reported');

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_records');
    }
};
