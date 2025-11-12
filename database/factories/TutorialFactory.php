<?php

namespace Modules\Helpcenter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Helpcenter\Models\Tutorial;

class TutorialFactory extends Factory
{
    protected $model = Tutorial::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        return [
            'uuid' => Str::uuid(),
            'title' => $title,
            'slug' => Str::slug($title),
            'category' => $this->faker->randomElement(['Guides', 'FAQ', 'Tech']),
            'summary' => $this->faker->text(120),
            'content' => $this->faker->paragraphs(4, true),
            'media' => [],
            'is_active' => $this->faker->boolean(90),
            'published_at' => now(),
        ];
    }
}
