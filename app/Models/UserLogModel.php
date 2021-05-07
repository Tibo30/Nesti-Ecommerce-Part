<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\UserLog;

class UserLogModel extends Model
{

    protected $table = 'user_logs'; // nom de la table
    protected $primaryKey = 'id_user_logs';
    protected $allowedFields = ['id_user_logs', 'connection_date', 'id_users']; // Nom des colonnes autorisées
    protected $returnType = UserLog::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation     = true;



}
