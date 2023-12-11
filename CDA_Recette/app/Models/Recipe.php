<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Recipe model",
 *     title="Recipe",
 *     required={"name", "preparationTime", "cookingTime", "serves"},
 *     @OA\Property(property="id", type="integer", format="int64", description="The unique identifier for the recipe"),
 *     @OA\Property(property="name", type="string", description="The name of the recipe"),
 *     @OA\Property(property="preparationTime", type="string", description="The preparation time of the recipe in minutes"),
 *     @OA\Property(property="cookingTime", type="string", description="The cooking time of the recipe in minutes"),
 *     @OA\Property(property="serves", type="integer", format="int32", description="The number of servings the recipe yields"),
 *     @OA\Property(property="ingredients", type="array", @OA\Items(ref="App\Models\Ingredient"))
 * )
 */
class Recipe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'preparationTime',
        'cookingTime',
        'serves',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'relations', 'recipe_id', 'ingredient_id');
    }
}
