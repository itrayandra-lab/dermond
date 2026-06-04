<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Bundle extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'subtitle',
        'price',
        'original_price',
        'benefits',
        'included_products',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'benefits' => 'array',
            'included_products' => 'array',
        ];
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => false,
            ],
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('bundle_images');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // Spatie auto-generates responsive sizes
    }

    /**
     * Get all bundle image URLs.
     *
     * @return array<string>
     */
    public function getImageUrls(): array
    {
        return $this->getMedia('bundle_images')->map(fn ($m) => $m->getUrl())->toArray();
    }

    public function getFirstImageUrl(): ?string
    {
        return $this->getFirstMedia('bundle_images')?->getUrl();
    }

    public function hasImages(): bool
    {
        return $this->hasMedia('bundle_images');
    }

    public function getSavingsAmount(): ?int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return $this->original_price - $this->price;
        }

        return null;
    }

    public function hasSavings(): bool
    {
        return $this->getSavingsAmount() !== null;
    }

    public function scopePublished($query): void
    {
        $query->where('status', 'published');
    }
}
