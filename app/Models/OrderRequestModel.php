<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\OrderRequest;

class OrderRequestModel extends Model
{

    protected $table = 'order_request'; // nom de la table
    protected $primaryKey = 'id_order';
    protected $allowedFields = ['id_order','state','creation_date','id_users']; // Nom des colonnes autorisées
    protected $returnType = OrderRequest::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;

    
}
