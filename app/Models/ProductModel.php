<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Product;

class ProductModel extends Model
{

    protected $table = 'products'; // nom de la table
    protected $primaryKey = 'id_products';
    protected $allowedFields = ['id_products', 'product_name']; // Nom des colonnes autorisées
    protected $returnType = Product::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;

    /**
     * Get the recipe's ingredients according to its ID
     * int $idRecipe
     */
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

    /**
     * search a product according to its name
     * String name
     */
    public function searchProduct(String $name){
        $builder = $this->db->table('products');
        $builder->like("product_name", "%".$name."%");
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Check if the product is an ingredient according to its ID
     * int $idProduct
     */
    public function isIngredient($idProduct){
        $query = $this->db->query('SELECT * FROM ingredients WHERE id_ingredients="' . $idProduct . '"');
        return $query->getResult();
    }


}
