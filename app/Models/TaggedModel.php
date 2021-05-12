<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Tagged;

class TaggedModel extends Model
{

    protected $table = 'tagged'; // nom de la table
    protected $primaryKey = 'id_tag, id_recipes';
    protected $allowedFields = ['id_tag', 'id_recipes']; // Nom des colonnes autorisées
    protected $returnType = Tagged::class; // Type de retour



    
}
