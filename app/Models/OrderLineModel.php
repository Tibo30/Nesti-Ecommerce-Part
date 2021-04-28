<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\OrderLine;

class OrderLineModel extends Model
{

    protected $table = 'order_line'; // nom de la table
    protected $primaryKey = 'id_order,id_article';
    protected $allowedFields = ['id_order','id_article','quantity_ordered']; // Nom des colonnes autorisées
    protected $returnType = OrderLine::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;

    
}
