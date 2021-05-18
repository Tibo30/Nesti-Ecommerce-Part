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


    public function findAllForApi()
    {
        $query = $this->db->query('SELECT * FROM `view_api_recipes`');
        return $query->getResult();
    }

    public function findCat($cat)
    {
        $query = $this->db->query('SELECT * FROM `view_api_recipes` WHERE id_tag="' . $cat . '"');
        return $query->getResult();
    }

    public function findRecipe($name)
    {
        $builder = $this->db->table('recipes');
        $builder->like("recipe_name", $name);
        $query = $builder->get();

        return $query->getResult();
    }

    // public function getRecipesbyTag(String $data)
    // {
    //     $query = $this->db->query('SELECT r.* FROM recipes r JOIN tagged td ON r.id_recipes=td.id_recipes JOIN tag t ON td.id_tag=t.id_tag WHERE r.state="a" AND t.name="' . $data . '"');
    //     return $query->getResult();
    // }

    // public function getRecipesbyTags(Array $tags)
    // { 
    //     $query = $this->db->query('SELECT DISTINCT r.* FROM recipes r JOIN tagged td ON r.id_recipes=td.id_recipes JOIN tag t ON td.id_tag=t.id_tag WHERE r.state="a" AND t.id_tag IN ("' . implode('","', $tags) . '")');
    //     return $query->getResult();
    // }

    public function searchRecipe(String $name){
        $builder = $this->db->table('recipes');
        $builder->like("recipe_name", "%".$name."%");
        $query = $builder->get();
        return $query->getResult();
    }


    // public function getRecipe($id){

    //     $query = $this->db->query('SELECT id_recipes, recipe_name FROM recipes WHERE id_recipes="' . $id . '"');


    //     $recipe = new Recipe();

    //     foreach ($query->getResult('array') as $row) {
    //         $recipe->setIdRecipe($row['id_recipes']);
    //         $recipe->setRecipeName($row['recipe_name']);
    //     }

    //     $query = $this->db->query('SELECT content FROM paragraph WHERE id_recipes="' . $id . '"');
    //     foreach ($query->getResult('array') as $row) {
    //         $preparations[] = $row['content'];

    //     }
    //     $recipe->preparations = $preparations;


    //     $query =  $this->db->query("SELECT i.id_produits as idproduit, p.nom_produits as nomProduit, i.quantite_ingredients_recette as qty, u.nom_unites_de_mesure as nomUnite, i.ordre_ingredients_recette as ordre"
    //             . " FROM ingredients_recettes as i, unites_de_mesure as u, produits as p WHERE i.id_unites_de_mesure = u.id_unites_de_mesure"
    //             . " AND i.id_produits = p.id_produits AND i.id_recettes ='" . $id .  "' ORDER BY ordre ASC");

    //     foreach ($query->getResult('array') as $row) {
    //         $ingredients[] = $row['nomProduit'] . ' ' . $row['qty'] . ' ' . $row["nomUnite"] ;
    //     }
    //     $recette->ingredients= $ingredients;
    //     return $recipe;
    // }
}
