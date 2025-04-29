<?php

namespace App\Providers;
use App\Repositories\Contracts\TutorRepositoryInterface;
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
        $this->app->bind(
            TutorRepositoryInterface::class, TutorRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
