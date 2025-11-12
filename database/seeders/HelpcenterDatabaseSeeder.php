<?php

namespace Modules\Helpcenter\Database\Seeders;

use Illuminate\Database\Seeder;

class HelpcenterDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            TagSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
