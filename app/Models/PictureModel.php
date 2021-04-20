<?php

namespace App\Models;

use CodeIgniter\Model;

class PictureModel extends Model
{

    protected $table = 'pictures'; // nom de la table
    protected $primaryKey = 'id_pictures';
    protected $allowedFields = ['id_pictures', 'name', 'extension']; // Nom des colonnes autorisées
    protected $returnType = 'App\Entities\Picture'; // Type de retour
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


    
}
