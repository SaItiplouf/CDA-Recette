<?php

namespace App\Console\Commands;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Relation;
use App\Services\ImportFileFactory;
use App\Services\ImportRecipesFromJson;
use Illuminate\Console\Command;

class ImportDataCommand extends Command
{
    protected $signature = 'app:import-data-command {file}';

    protected $description = 'Importe des données à partir d\'un fichier JSON';

    public function __construct(private ImportFileFactory $importFactory) {
        parent::__construct();
    }


    public function handle()
    {
        $filePath = storage_path('app\public\\' . $this->argument('file'));

        $importService = $this->importFactory->chooseImportService($filePath);

        $importService->import($filePath);

        $this->info('Données importées avec succès.');
    }

}
