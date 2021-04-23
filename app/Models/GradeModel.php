<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Grade;

class GradeModel extends Model
{

    protected $table = 'grade'; // nom de la table
    protected $primaryKey = 'id_users,id_recipes';
    protected $allowedFields = ['id_users', 'id_recipes', 'grade']; // Nom des colonnes autorisées
    protected $returnType = Grade::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;


    
}
