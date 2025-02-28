<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Venue extends Model
{
    protected $fillable = ['name', 'slug', 'address', 'phone', 'featured_image', 'user_id'];

    protected $appends = ['featured_image_url'];

    public function getFeaturedImageUrlAttribute()
    {
        return asset($this->featured_image);
    }

    /**
     * Mekanın adından otomatik olarak slug'ı oluşturur.
     * @param mixed $value
     * @return void
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        $this->setSlugAttribute($value);
    }

    /**
     * Mekan kısa adını otomatik olarak kontrol eder.
     * @param mixed $value
     * @return void
     */
    public function setSlugAttribute($value): void
    {
        $slug = Str::slug($value);

        $originalSlug = $slug;
        $counter = 1;

        // Slug zaten var mı diye kontrol ediyoruz
        while (Venue::where('slug', $slug)->where('id', '!=', $this->id ?? null)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Sonuçta oluşturduğumuz slug'ı atıyoruz
        $this->attributes['slug'] = $slug;
    }

    /**
     * Mekanın sahibi ile olan ilişkiyi tanımlar.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mekanın kategorileri ile olan ilişkiyi tanımlar.
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Mekanın ürünleri ile olan ilişkiyi tanımlar.
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
