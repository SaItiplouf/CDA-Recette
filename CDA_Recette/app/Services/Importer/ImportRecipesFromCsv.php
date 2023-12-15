<?php

namespace App\Services\Importer;


class ImportRecipesFromCsv extends ImporterClass
{
    public function import($filename): void
    {
        $processedData = $this->processCsv($filename);
        $this->pushToDb($processedData);
    }


    public function processCsv($fileName)
    {
        $csvData = array_map('str_getcsv', file($fileName));
        $header = array_shift($csvData);

        $recipes = [];

        foreach ($csvData as $rowData) {
            $recipeData = array_combine($header, $rowData);
            $recipes[] = $recipeData;
        }

        return ['recipes' => $recipes];
    }
}
