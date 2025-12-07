<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Slider extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'title',
        'subtitle',
        'description',
        'cta_text',
        'cta_link',
        'product_id',
        'badge_title',
        'badge_subtitle',
        'status',
        'position',
    ];

    /**
     * Get the product associated with this slider.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the display title (from slider or linked product).
     */
    public function getDisplayTitle(): string
    {
        return $this->title ?? $this->product?->name ?? 'Dermond';
    }

    /**
     * Get the display subtitle.
     */
    public function getDisplaySubtitle(): ?string
    {
        return $this->subtitle ?? $this->product?->category?->name;
    }

    /**
     * Get the display price (only if linked to product).
     */
    public function getDisplayPrice(): ?int
    {
        return $this->product?->getCurrentPrice();
    }

    /**
     * Get the original price (only if linked to product with discount).
     */
    public function getOriginalPrice(): ?int
    {
        if ($this->product && $this->product->hasDiscount()) {
            return $this->product->price;
        }

        return null;
    }

    /**
     * Check if slider has discount price.
     */
    public function hasDiscount(): bool
    {
        return $this->product?->hasDiscount() ?? false;
    }

    /**
     * Get the CTA link (product page or custom link).
     */
    public function getCtaLink(): ?string
    {
        if ($this->product) {
            return route('products.show', $this->product->slug);
        }

        return $this->cta_link;
    }

    /**
     * Get the CTA text.
     */
    public function getCtaText(): string
    {
        return $this->cta_text ?? 'MORE DETAILS';
    }

    /**
     * Get display image URL (slider image or product image).
     */
    public function getDisplayImageUrl(): ?string
    {
        if ($this->hasImage()) {
            return $this->getImageUrl();
        }

        return $this->product?->getImageUrl();
    }

    /**
     * Check if slider has displayable image.
     */
    public function hasDisplayImage(): bool
    {
        return $this->hasImage() || $this->product?->hasImage();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Define media collections for this model
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('slider_images')
            ->singleFile();
    }

    /**
     * Define media conversions
     * Using Spatie's built-in responsive images
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // No conversions needed - Spatie will auto-generate responsive sizes
        // The original image will be served with responsive srcset
    }

    /**
     * Get slider image URL
     */
    public function getImageUrl(): ?string
    {
        return $this->getFirstMedia('slider_images')?->getUrl();
    }

    /**
     * Get slider image for responsive display
     */
    public function getImage()
    {
        return $this->getFirstMedia('slider_images');
    }

    /**
     * Check if slider has image
     */
    public function hasImage(): bool
    {
        return $this->hasMedia('slider_images');
    }

    /**
     * Scope a query to order sliders by order field.
     */
    public function scopeOrderedByOrder($query)
    {
        return $query->orderBy('position', 'asc')->orderBy('created_at', 'asc');
    }

    /**
     * Scope active sliders.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
