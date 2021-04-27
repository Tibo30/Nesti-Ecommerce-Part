<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Ingredient;

class IngredientModel extends Model
{

    protected $table = 'products'; // nom de la table
    protected $primaryKey = 'id_products';
    protected $allowedFields = ['id_products', 'product_name']; // Nom des colonnes autorisées
    protected $returnType = Ingredient::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;

    public function getIngredients($idRecipe)
    {
        $builder = $this->db->table('recipe_ingredients');
        $builder->select('ingredients.id_ingredients, products.product_name, recipe_ingredients.quantity,unit_measures.name AS unit_name');
        $builder->join('ingredients', 'ingredients.id_ingredients = recipe_ingredients.id_ingredients');
        $builder->join('products', 'ingredients.id_ingredients = products.id_products');
        $builder->join('unit_measures', 'unit_measures.id_unit_measures = recipe_ingredients.id_unit_measures');
        $builder->where('recipe_ingredients.id_recipes', $idRecipe);
        $query = $builder->get();

        return $query->getResult();
    }


}
