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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->nullable()->default(null)->constrained()->nullOnDelete();
            $table->foreignId('release_type_id')->nullable()->default(null)->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('year', 4);
            $table->string('duration', 10);
            $table->string('label', 50)->nullable()->default(null);
            $table->string('genres', 100)->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
