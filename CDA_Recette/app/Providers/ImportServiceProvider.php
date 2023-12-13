<?php

namespace App\Providers;

use App\Services\ImportFileFactory;
use App\Services\ImportRecipesFromCsv;
use App\Services\ImportRecipesFromJson;
use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(ImportFileFactory::class, function ($app) {
            return new ImportFileFactory([
                'csv' => ImportRecipesFromCsv::class,
                'json' => ImportRecipesFromJson::class,
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
