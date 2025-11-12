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
        Schema::create('taggables', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();

            $table->nullableMorphs('taggable'); // crée taggable_id (UBIGINT) + taggable_type (STRING) + index
            $table->timestamps();

            // Empêche les doublons du même tag sur la même ressource
            $table->unique(['tag_id', 'taggable_type', 'taggable_id'], 'unique_taggable');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggables');
    }
};
