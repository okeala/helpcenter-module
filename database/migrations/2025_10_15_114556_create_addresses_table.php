<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            // Person (Person étend User => table 'users')
            $table->foreignId('person_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->unique(); // une adresse par personne

            // Adresse postale
            $table->string('line1')->nullable();
            $table->string('line2')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country_code', 2)->default('PT');

            $table->geography('location');

            // Index spatial
            $table->spatialIndex('location');

            // Colonnes dérivées pratiques (MySQL uniquement)
            if (DB::getDriverName() === 'mysql') {
                $table->decimal('lat', 10, 7)->virtualAs('ST_Y(`location`)');
                $table->decimal('lng', 10, 7)->virtualAs('ST_X(`location`)');
            }

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
