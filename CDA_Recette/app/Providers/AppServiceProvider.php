<?php

namespace App\Providers;

use App\Services\ImportRecipesFromJson;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ImportRecipesFromJson::class, function ($app) {
            return new ImportRecipesFromJson();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
