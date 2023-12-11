<?php

namespace App\Services;

use App\Models\Ingredient;
use App\Models\Recipe;

class ImportRecipesFromJson
{
    public function import($filePath)
    {
        $data = json_decode(file_get_contents($filePath), true);

        foreach ($data['recipes'] as $recipeData) {
            $recipe = new Recipe();
            $recipe->fill($recipeData);
            $recipe->save();

            foreach ($recipeData['ingredients'] as $ingredientName) {
                $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);

                $recipe->ingredients()->attach($ingredient->id);
            }
        }
    }
}
