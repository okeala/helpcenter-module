<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->string('slug');                 // ex: 'agroforesterie'
            $table->string('type')->nullable()->index(); // ex: 'post', 'product', 'global'...
            $table->string('color', 32)->nullable()->default('gray-100');     // ex: '#10B981' ou 'emerald-500'
            $table->longText('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            // Unicité par (slug, type) pour autoriser le même slug sur des taxonomies différentes
            $table->unique(['slug', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
