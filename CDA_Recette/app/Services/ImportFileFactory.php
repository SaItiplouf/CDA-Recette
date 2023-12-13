<?php

namespace App\Services;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Support\Facades\File;

class ImportFileFactory
{
    public function __construct(private array $importers)
    {
    }

    public function chooseImportService(string $filename)
    {
        if (File::exists($filename)) {
            $extension = File::extension($filename);

            if (isset($this->importers[$extension])) {
                return app($this->importers[$extension]);
            } else {
                throw new \InvalidArgumentException("Unsupported file extension: $extension");
            }

        } else {
            throw new \InvalidArgumentException("File not found: $filename");
        }
    }
}

abstract class ImporterFromFile {
    abstract public function import($filename): void;

    protected function getFileData(string $filename)
    {
        return file_get_contents($filename);
    }

    protected function pushToDb(array $data) {
        try {
            foreach ($data['recipes'] as $recipeData) {
                $recipe = new Recipe();
                $recipe->fill($recipeData);
                if (!$recipe->save()) {
                    throw new \RuntimeException("Failed to save the recipe to the database");
                }

                if (isset($recipeData['ingredients'])) {
                    if (is_array($recipeData['ingredients'])) {
                        $ingredients = $recipeData['ingredients'];
                    } else {
                        $ingredients = explode(', ', $recipeData['ingredients']);
                    }

                    foreach ($ingredients as $ingredientName) {
                        $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);
                        $recipe->ingredients()->attach($ingredient->id);
                    }
                }
            }
        } catch (\Exception $e) {
            throw new \RuntimeException($e);
        }
    }
}
