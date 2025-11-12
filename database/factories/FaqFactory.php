<?php

namespace Modules\Helpcenter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Helpcenter\Models\Faq;
use Modules\People\Models\Person;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
        // On essaye de lier à une Person si possible, sinon null
        return [
            'question'      => $this->faker->sentence(8) . ' ?',
            'answer'        => $this->faker->paragraphs(3, true),
            'is_published'  => $this->faker->boolean(70),
            'published_at'  => $this->faker->boolean(70)
                ? $this->faker->dateTimeBetween('-6 months', 'now')
                : null,
            'author_id'     => Person::query()->inRandomOrder()->value('id') ?? null,
        ];
    }

    /**
     * État publié.
     */
    public function published(): static
    {
        return $this->state(fn () => [
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    /**
     * État brouillon.
     */
    public function draft(): static
    {
        return $this->state(fn () => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}
