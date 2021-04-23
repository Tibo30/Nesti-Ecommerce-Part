<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\RecipeIngredient;

class RecipeIngredientModel extends Model
{

    protected $table = 'recipe_ingredients'; // nom de la table
    protected $primaryKey = 'id_recipes, id_ingredients';
    protected $allowedFields = ['quantity', 'order_ingredient', 'id_unit_measures', 'id_recipes', 'id_ingredients']; // Nom des colonnes autorisées
    protected $returnType = RecipeIngredient::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;

    public function getRecipeIngredients($idRecipe){
        $builder = $this->db->table('recipe_ingredients');
        $builder->select('recipe_ingredients.quantity, recipe_ingredients.order_ingredient, recipe_ingredients.id_unit_measures, recipe_ingredients.id_recipes, recipe_ingredients.id_ingredients');
        $builder->select('recipe_ingredients.*');
        $builder->join('ingredients', 'ingredients.id_ingredients = recipe_ingredients.id_ingredients');
        $builder->join('products', 'ingredients.id_ingredients = products.id_products');
        $builder->join('unit_measures', 'unit_measures.id_unit_measures = recipe_ingredients.id_unit_measures');
        $builder->where('recipe_ingredients.id_recipes', $idRecipe);
        $query = $builder->get();

        return $query->getResult();
    }



}
