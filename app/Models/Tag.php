<?php

namespace Modules\Helpcenter\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Helpcenter\Database\Factories\TagFactory;
use Modules\People\Models\Person;
use Modules\Workshops\Models\Workshop;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_PERSON = 'person';
    public const TYPE_GLOBAL = 'global';

    protected $fillable = ['name', 'slug', 'type', 'color', 'description'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Tag $tag) {
            if (blank($tag->slug) && filled($tag->name)) {
                $tag->slug = Str::slug($tag->name);
            }
            if ($tag->type === '') {
                $tag->type = null;
            }
        });
    }

    /** Tous les People taggés par ce tag */
    public function people(): MorphToMany
    {
        return $this->morphedByMany(Person::class, 'taggable')->withTimestamps();
    }

    /** Tous les workshops taggés par ce tag */
    public function workshops(): MorphToMany
    {
        return $this->morphedByMany(Workshop::class, 'taggable')->withTimestamps();
    }

    /** Scopes utilitaires */
    public function scopeType(Builder $q, ?string $type): Builder
    {
        return $type ? $q->where('type', $type) : $q;
    }

    public function scopeSearch(Builder $q, string $term): Builder
    {
        $term = trim($term);
        if ($term === '') return $q;
        return $q->where(fn ($qq) =>
        $qq->where('name', 'like', "%{$term}%")
            ->orWhere('slug', 'like', "%{$term}%")
        );
    }

    public static function newFactory()
    {
        return TagFactory::new();
    }
}
