<?php

namespace App\Services\Importer;

use App\Models\Ingredient;

class ImporterPersistanceMysql implements ImporterPersistanceInterface {

    public function importData($data)
    {
        $data->save();

        if (isset($data->ingredients)) {
            foreach ($data->ingredients as $ingredient) {
                $ingredientModel = Ingredient::firstOrCreate(['name' => $ingredient->name]);
                $data->ingredients()->attach($ingredientModel->id);
            }
        }
    }
}
