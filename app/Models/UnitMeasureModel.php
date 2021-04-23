<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\UnitMeasure;

class UnitMeasureModel extends Model
{

    protected $table = 'unit_measures'; // nom de la table
    protected $primaryKey = 'id_unit_measures';
    protected $allowedFields = ['id_unit_measures', 'name']; // Nom des colonnes autorisées
    protected $returnType = UnitMeasure::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation     = true;
}
