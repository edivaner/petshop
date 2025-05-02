<?php

namespace App\Providers;

use App\Repositories\Contracts\AnimalRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TutorRepositoryInterface;
use App\Repositories\Eloquent\AnimalRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\TutorRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(TutorRepositoryInterface::class, TutorRepository::class);
        $this->app->bind(AnimalRepositoryInterface::class, AnimalRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
