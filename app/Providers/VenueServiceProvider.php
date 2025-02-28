<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\VenueRepositoryInterface;
use App\Repositories\VenueRepository;
use App\Contracts\Services\VenueServiceInterface;
use App\Services\VenueService;

class VenueServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(VenueServiceInterface::class, VenueService::class);
        $this->app->bind(VenueRepositoryInterface::class, VenueRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
