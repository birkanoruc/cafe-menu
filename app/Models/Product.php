<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['venue_id', 'category_ids', 'name', 'description', 'price', 'discount_price', 'featured_image'];

    public function getFeaturedImageUrlAttribute()
    {
        return asset($this->featured_image);
    }

    /**
     * Ürün adından otomatik olarak slug'ı oluşturur.
     * @param mixed $value
     * @return void
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        $this->setSlugAttribute($value);
    }

    /**
     * Ürün kısa adını otomatik olarak kontrol eder.
     * @param mixed $value
     * @return void
     */
    public function setSlugAttribute($value): void
    {
        $slug = Str::slug($value);

        $orginalSlug = $slug;
        $counter = 1;

        $venueId = $this->venue_id ?? request()->input('venue_id'); // Eğer modelde varsa, o id'yi al, yoksa request'ten al

        // Slug zaten var mı diye kontrol ediyoruz
        while (Product::where('slug', $slug)
            ->where('venue_id', $venueId)
            ->where('id', '!=', $this->id ?? null)->exists()
        ) {
            // Eğer varsa, sonuna numara ekleyerek yeni slug oluşturuyoruz
            $slug = $orginalSlug . '-' . $counter;
            $counter++;
        }

        // Sonuçta oluşturduğumuz slug'ı atıyoruz
        $this->attributes['slug'] = $slug;
    }

    /**
     * Ürünün mekan ile olan ilişkisini tanımlar.
     * @return BelongsTo
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * Ürünün kategorileri ile olan ilişkisini tanımlar.
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }
}
