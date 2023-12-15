<?php

namespace App\Providers;

use App\Repositories\RecipesRepository;
use App\Services\Importer\ImporterPersistanceMysql;
use App\Services\Importer\ImportRecipesFromJson;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class ImportServiceProvider extends ServiceProvider
{


    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(ImporterPersistanceMysql::class, function ($app) {
            return new ImporterPersistanceMysql();
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
