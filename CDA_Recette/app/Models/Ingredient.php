<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Ingredient model",
 *     title="Ingredient",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", description="The name of the ingredient"),
 * )
 */
class Ingredient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'relations', 'ingredient_id', 'recipe_id');
    }
}
