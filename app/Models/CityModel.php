<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\City;

class CityModel extends Model
{

    protected $table = 'city'; // nom de la table
    protected $primaryKey = 'id_city';
    protected $allowedFields = ['city_name']; // Nom des colonnes autorisées
    protected $returnType = City::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;

}
