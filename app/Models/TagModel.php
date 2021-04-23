<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Tag;

class TagModel extends Model
{

    protected $table = 'tag'; // nom de la table
    protected $primaryKey = 'id_tag';
    protected $allowedFields = ['id_tag', 'name']; // Nom des colonnes autorisées
    protected $returnType = Tag::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $validationRules = [
        'name' => 'required|alpha_numeric_space|min_length[3]',
        //'slug' => 'required|alpha_numeric|min_length[2]|is_unique[tag.slug]',
    ];
    protected $validationMessages = [
        'slug' => [
            'is_unique' => 'Désolé. Ce tag est déjà pris. Veuillez enchoisir un autre.'
        ]
    ];
    protected $skipValidation     = false;


    /**
     * 
     * @param int $id_tag
     * @param int $id_recipe
     * @return bool 
     */
    public function removeTag(int $id_tag, int $id_recipe): bool
    {
        $builder = $this->db->table('tag');
        $verdict = ($builder->delete([
            'id_tag' => $id_tag
        ]) != false);
        return $verdict;
    }

    public function tagsByRecipe(int $id_recipes){
        $query = $this->db->query('SELECT * FROM tag t JOIN tagged td ON td.id_tag=t.id_tag WHERE td.id_recipes="' . $id_recipes . '"');
        return $query->getResult();
    }

    
}
