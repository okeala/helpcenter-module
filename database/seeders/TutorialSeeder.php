<?php

namespace Modules\Helpcenter\Database\Seeders;

use Illuminate\Database\Seeder;

class TutorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Modules\Helpcenter\Models\Tutorial::factory()->count(5)->create();
    }

}
