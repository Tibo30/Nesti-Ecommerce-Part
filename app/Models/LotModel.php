<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Lot;

class LotModel extends Model
{

    protected $table = 'lots'; // nom de la table
    protected $primaryKey = 'ref_order,id_article';
    protected $allowedFields = ['ref_order','id_article','unit_cost','bought_quantity','received_date']; // Nom des colonnes autorisées
    protected $returnType = Lot::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;
}
