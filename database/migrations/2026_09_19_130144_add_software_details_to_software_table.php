<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('software', function (Blueprint $table) {
           $table->string('publisher')->nullable();
            $table->string('category')->nullable();
            $table->unsignedInteger('licenses')->default(0);
            $table->unsignedInteger('installed')->default(0);
            $table->date('expiry')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('software', function (Blueprint $table) {
            $table->dropColumn([
                'publisher',
                'licenses',
                'installed',
                'expiry',
                'icon',
                'color',
            ]);
        });
    }
};