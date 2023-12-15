<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Services\Importer\ImporterPersistanceMysql;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipesRepository extends Controller {

    public function __construct(private Request $request)
    {
    }
    public function persist($recipeData): void {

        $recipe = Recipe::create($recipeData);

        $importerPersistance = app(ImporterPersistanceMysql::class);
        $importerPersistance->importData($recipe);

    }
    public function getCollection(): JsonResponse {

        $recipes = Recipe::with('ingredients')->get();

        $recipesJson = $recipes->map(function ($recipe) {
            return [
                'id' => $recipe->id,
                'name' => $recipe->name,
                'preparationTime' => $recipe->preparationTime,
                'cookingTime' => $recipe->cookingTime,
                'serves' => $recipe->serves,
                'ingredients' => $recipe->ingredients->pluck('name'),
            ];
        });

        return response()->json($recipesJson);
    }

    public function post(): JsonResponse {
        // Créer la recette principale
        $recipe = Recipe::create($this->request->only(['name', 'preparationTime', 'cookingTime', 'serves']));

        // Ajouter les ingrédients associés
        if ($this->request->has('ingredients') && is_array($this->request->input('ingredients'))) {
            foreach ($this->request->input('ingredients') as $ingredientData) {

                if (isset($ingredientData['name'])) {
                    $existingIngredient = Ingredient::where('name', $ingredientData['name'])->first();

                    if ($existingIngredient) {
                        $recipe->ingredients()->attach($existingIngredient->id);
                    } else {
                        $newIngredient = Ingredient::create(['name' => $ingredientData['name']]);
                        $recipe->ingredients()->attach($newIngredient->id);
                    }
                }
            }
        }

        $recipe = $recipe->load('ingredients');

        return response()->json($recipe, 201);
    }

    public function get($id): JsonResponse {
        $recipe = Recipe::with('ingredients')->find($id);

        if (!$recipe) {
            return response()->json(['error' => 'Recette non trouvée'], 404);
        }

        $recipeJson = [
            'id' => $recipe->id,
            'name' => $recipe->name,
            'preparationTime' => $recipe->preparationTime,
            'cookingTime' => $recipe->cookingTime,
            'serves' => $recipe->serves,
            'ingredients' => $recipe->ingredients->pluck('name'),
        ];

        return response()->json($recipeJson);
    }

    public function update($id): JsonResponse {
        $recipe = Recipe::findOrFail($id);
        $recipe->update($this->request->all());

        return response()->json($recipe, 200);
    }

    public function delete($id): JsonResponse {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json(['error' => 'Recette non trouvée'], 404);
        }

        $recipe->delete();

        return response()->json(['message' => 'Recette supprimée avec succès'], 200);
    }


}
