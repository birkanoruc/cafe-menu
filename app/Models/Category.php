<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['venue_id', 'name', 'slug', 'featured_image'];

    public function getFeaturedImageUrlAttribute()
    {
        return asset($this->featured_image);
    }

    /**
     * Kategorinin adından otomatik olarak slug'ı oluşturur.
     * @param mixed $value
     * @return void
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        $this->setSlugAttribute($value);
    }

    /**
     * Kategori kısa adını otomatik olarak kontrol eder.
     * @param mixed $value
     * @return void
     */
    public function setSlugAttribute($value): void
    {
        $slug = Str::slug($value);

        $originalSlug = $slug;
        $counter = 1;

        $venueId = $this->venue_id ?? request()->input('venue_id'); // Eğer modelde varsa, o id'yi al, yoksa request'ten al

        // Slug zaten var mı diye kontrol ediyoruz
        while (Category::where('slug', $slug)
            ->where('venue_id', $venueId)
            ->where("id", "!=", $this->id ?? null)
            ->exists()
        ) {
            // Eğer varsa, sonuna numara ekleyerek yeni slug oluşturuyoruz
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Sonuçta oluşturduğumuz slug'ı atıyoruz
        $this->attributes['slug'] = $slug;
    }

    /**
     * Kategorinin mekan ile olan ilişkisini tanımlar.
     * @return BelongsTo
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * Kategorinin ürünleri ile olan ilişkisini tanımlar.
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
