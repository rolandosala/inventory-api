<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_software', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->foreignId('software_id')
                ->constrained('software')
                ->cascadeOnDelete();

            $table->date('installed_at')->nullable();

            $table->string('license_key')->nullable();

            $table->string('status')->default('installed');

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->unique(['asset_id', 'software_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_software');
    }
};