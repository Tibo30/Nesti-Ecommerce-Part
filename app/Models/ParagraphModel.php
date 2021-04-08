<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Recipe;

class ParagraphModel extends Model
{

    protected $table = 'paragraph'; // nom de la table
    protected $primaryKey = 'id_paragraph';
    protected $allowedFields = ['content','order_paragraph','creation_date','id_recipes']; // Nom des colonnes autorisées
    protected $returnType = 'App\Entities\Paragraph'; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

   
    public function getParagraphs($idRecipe)
    {
        $builder = $this->db->table('paragraph');
        $builder->select('content,order_paragraph');
        $builder->where('id_recipes', $idRecipe);
        $builder->orderBy('order_paragraph','ASC');
        $query = $builder->get();

        return $query->getResult();
    }

}
