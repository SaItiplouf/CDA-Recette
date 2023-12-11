<?php

namespace App\Http\Controllers;

use App\Repositories\RecipesRepository;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="API de Recettes",
 *      version="1.0.0",
 *      description="Documentation de l'API de recettes",
 * )
 */
class RecipeController extends Controller
{

    public function __construct(private RecipesRepository $recipesRepository) {}

    /**
     * @OA\Get(
     *      path="/api/recipes",
     *      operationId="getRecettesList",
     *      tags={"Recettes"},
     *      summary="Récupérer la liste des recettes",
     *      description="Retourne la liste des recettes avec les ingrédients",
     *      @OA\Response(
     *          response=200,
     *          description="Opération réussie",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="App\Models\Recipe")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Mauvaise requête",
     *      ),
     * )
     */
    public function index()
    {
        $recipes = $this->recipesRepository->getCollection();

        return $recipes;
    }

    /**
     * @OA\Post(
     *      path="/api/recipes",
     *      operationId="createRecipe",
     *      tags={"Recettes"},
     *      summary="Créer une nouvelle recette",
     *      description="Crée une nouvelle recette avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              required={"name", "preparationTime", "cookingTime", "serves"},
     *              @OA\Property(property="name", type="string", example="Poulet rôti"),
     *              @OA\Property(property="preparationTime", type="string", example="20 minutes"),
     *              @OA\Property(property="cookingTime", type="string", example="1 heure"),
     *              @OA\Property(property="serves", type="integer", format="int32", example=4),
     *             @OA\Property(
     *                  property="ingredients",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      required={"name"},
     *                      @OA\Property(property="name", type="string", example="Choux-fleur"),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Recette créée avec succès",
     *          @OA\JsonContent(ref="App\Models\Recipe"),
     *          @OA\Examples(example="Création réussie", value={"id": 1, "name": "Poulet rôti", "preparationTime": "20 minutes", "cookingTime": "1 heure", "serves": 4})
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Mauvaise requête",
     *      ),
     * )
     */

    public function store()
    {
            $request = $this->recipesRepository->post();

            return $request;
    }

    /**
     * @OA\Get(
     *      path="/api/recipes/{id}",
     *      operationId="getRecipeById",
     *      tags={"Recettes"},
     *      summary="Récupérer une recette par ID",
     *      description="Retourne une recette avec les ingrédients associés par ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la recette",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Opération réussie",
     *          @OA\JsonContent(ref="App\Models\Recipe")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Recette non trouvée",
     *      ),
     * )
     */
    public function show($id)
    {
        $recipe = $this->recipesRepository->get($id);

        return $recipe;

    }

    /**
     * @OA\Put(
     *      path="/api/recipes/{id}",
     *      operationId="updateRecipe",
     *      tags={"Recettes"},
     *      summary="Mettre à jour une recette par ID",
     *      description="Met à jour une recette avec les détails fournis par ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la recette",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="App\Models\Recipe")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Recette mise à jour avec succès",
     *          @OA\JsonContent(ref="App\Models\Recipe")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Recette non trouvée",
     *      ),
     * )
     */
    public function update($id)
    {
        $recipe = $this->recipesRepository->update($id);

        return $recipe;
    }

    /**
     * @OA\Delete(
     *      path="/api/recipes/{id}",
     *      operationId="deleteRecipe",
     *      tags={"Recettes"},
     *      summary="Supprimer une recette par ID",
     *      description="Supprime une recette par ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la recette",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Recette supprimée avec succès",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Recette non trouvée",
     *      ),
     * )
     */
    public function destroy($id)
    {
        $request =  $this->recipesRepository->delete($id);

        return $request;
    }
}
