<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class VenueFilter
{
    public $name; // Mekan adı
    public $address; // Mekan adresi
    public $sort_by; // Sıralama alanı (name, price, created_at, updated_at)
    public $sort_order; // Sıralama yönü (asc, desc)
    public $page; // Sayfa numarası
    public $per_page; // Sayfa başına gösterilecek kayıt sayısı

    public function __construct(array $venueFilters = [])
    {
        $this->name = $venueFilters['name'] ?? null;
        $this->address = $venueFilters['address'] ?? null;
        $this->sort_by = $venueFilters['sort_by'] ?? 'created_at';
        $this->sort_order = $venueFilters['sort_order'] ?? 'asc';
        $this->page = $venueFilters['page'] ?? 1;
        $this->per_page = $venueFilters['per_page'] ?? 10;
    }

    public function applyFilters(Builder $query): LengthAwarePaginator
    {
        if ($this->name) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }

        if ($this->address) {
            $query->where('address', 'like', '%' . $this->address) . '%';
        }

        $query->orderBy($this->sort_by, $this->sort_order);

        return $query->paginate($this->per_page);
    }
}
