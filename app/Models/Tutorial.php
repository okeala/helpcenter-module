<?php

namespace Modules\Helpcenter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Helpcenter\Database\Factories\TutorialFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Tutorial extends Model implements HasMedia
{
    use HasTranslations;
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'category',
        'summary',
        'content',
        'media',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'media' => 'array',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected array $translatable = [
        'title',
        'summary',
        'content',
    ];

    protected static function booted(): void
    {
        static::creating(fn($tutorial) => $tutorial->uuid = $tutorial->uuid ?? (string) Str::uuid());
        static::saving(fn($tutorial) => $tutorial->slug = Str::slug($tutorial->title));
    }

    protected static function newFactory()
    {
        return TutorialFactory::new();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery')
            ->useDisk('public')
            ->acceptsFile(function (Media $media) {
                return in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/webp']);
            });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(480)
            ->height(320)
            ->sharpen(10)
            ->performOnCollections('cover', 'gallery');
    }
}
