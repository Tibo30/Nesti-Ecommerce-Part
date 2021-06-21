<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Recipe;

class RecipeModel extends Model
{

    protected $table = 'recipes'; // nom de la table
    protected $primaryKey = 'id_recipes';
    protected $allowedFields = ['recipe_name', 'difficulty', 'number_of_people', 'state', 'time', 'id_pictures', 'id_chief']; // Nom des colonnes autorisées
    protected $returnType = Recipe::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * get all the datas from the view
     */
    public function findAllForApi()
    {
        $query = $this->db->query('SELECT * FROM `view_api_recipes`');
        return $query->getResult();
    }

    /**
     * Get a category (tag) according to its ID
     * int $cat
     */
    public function findCat($cat)
    {
        $query = $this->db->query('SELECT * FROM `view_api_recipes` WHERE id_tag="' . $cat . '"');
        return $query->getResult();
    }

    /**
     * Get a recipe according to its name
     * string $name
     */
    public function findRecipe($name)
    {
        $builder = $this->db->table('recipes');
        $builder->where("state", "a");
        $builder->like("recipe_name", $name);
        $query = $builder->get();

        return $query->getResult();
    }

    /**
     * Search recipes according to a string
     * String $name
     */
    public function searchRecipe(String $name)
    {
        $builder = $this->db->table('recipes');
        $builder->like("recipe_name", "%" . $name . "%");
        $query = $builder->get();
        return $query->getResult();
    }
}
