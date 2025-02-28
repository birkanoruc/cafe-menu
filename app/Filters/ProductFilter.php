<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductFilter
{
    public $name; // Ürün adı
    public $min_price; // En az fiyat
    public $max_price; // En fazla fiyat
    public $sort_by; // Sıralama alanı (name, price, created_at, updated_at)
    public $sort_order; // Sıralama yönü (asc, desc)
    public $page; // Sayfa numarası
    public $per_page; // Sayfa başına gösterilecek kayıt sayısı

    public function __construct(array $productFilters = [])
    {
        $this->name = $productFilters['name'] ?? null;
        $this->min_price = $productFilters['min_price'] ?? null;
        $this->max_price = $productFilters['max_price'] ?? null;
        $this->sort_by = $productFilters['sort_by'] ?? 'created_at';
        $this->sort_order = $productFilters['sort_order'] ?? 'asc';
        $this->page = $productFilters['page'] ?? 1;
        $this->per_page = $productFilters['per_page'] ?? 10;
    }

    public function applyFilters(Builder $query): LengthAwarePaginator
    {
        if ($this->name) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }

        if ($this->min_price) {
            $query->where('price', '>=', $this->min_price);
        }

        if ($this->max_price) {
            $query->where('price', '<=', $this->max_price);
        }

        $query->orderBy($this->sort_by, $this->sort_order);

        return $query->paginate($this->per_page);
    }
}
