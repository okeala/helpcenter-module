<?php

namespace Modules\Helpcenter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;       // pour le state createdBy()
use Modules\Helpcenter\Models\Tag;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $name = Str::title($this->faker->unique()->words(2, true)); // ex: "Water Retention"
        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'type'        => 'global',         // par défaut: global
            'color'       => 'gray-100',       // défaut du schéma
            'description' => $this->faker->optional()->sentence(),
            'created_by'  => null,             // nullable FK vers users.id
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }

    /* ---------- States utiles ---------- */

    /** Définit le type générique */
    public function type(string $type): static
    {
        return $this->state(fn () => ['type' => $type]);
    }

    /** Tag global (helpcenter/topics) */
    public function global(): static
    {
        return $this->type('global');
    }

    /** Tag destiné aux personnes (catégories/roles) */
    public function person(): static
    {
        return $this->type('person');
    }

    /** Définit un nom (et son slug auto) */
    public function named(string $name, ?string $slug = null): static
    {
        return $this->state(function () use ($name, $slug) {
            return [
                'name' => $name,
                'slug' => Str::slug($slug ?? $name),
            ];
        });
    }

    /** Définit la couleur (hex ou tailwind token) */
    public function color(string $color): static
    {
        return $this->state(fn () => ['color' => $color]);
    }

    /** Définit la description */
    public function described(string $description): static
    {
        return $this->state(fn () => ['description' => $description]);
    }

    /** Associe un auteur (FK created_by) */
    public function createdBy(User|int $user): static
    {
        $userId = $user instanceof User ? $user->id : $user;
        return $this->state(fn () => ['created_by' => $userId]);
    }
}
