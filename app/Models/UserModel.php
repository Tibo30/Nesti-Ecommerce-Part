<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UserModel extends Model
{

    protected $table = 'users'; // nom de la table
    protected $primaryKey = 'id_users';
    protected $allowedFields = ['id_users', 'lastname', 'firstname', 'username', 'email', 'password', 'state', 'creation_date', 'address1', 'address2', 'poscode', 'id_city']; // Nom des colonnes autorisées
    protected $returnType = User::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation     = true;
}
