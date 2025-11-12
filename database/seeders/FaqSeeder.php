<?php

namespace Modules\Helpcenter\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Helpcenter\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // Quelques FAQ publiées
        Faq::factory()
            ->count(10)
            ->published()
            ->create();

        // Quelques FAQ en brouillon
        Faq::factory()
            ->count(5)
            ->draft()
            ->create();
    }
}
