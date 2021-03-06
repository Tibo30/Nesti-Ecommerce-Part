<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UserModel extends Model
{

    protected $table = 'users'; // nom de la table
    protected $primaryKey = 'id_users';
    protected $allowedFields = ['id_users', 'lastname', 'firstname', 'username', 'email', 'password', 'state', 'creation_date', 'address1', 'address2', 'postcode', 'id_city']; // Nom des colonnes autorisées
    protected $returnType = User::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation     = true;

    /**
     * Check if a user is a chief according to its ID
     * int $idUser
     */
    public function isChief($idUser)
    {
        $query = $this->db->query('SELECT * FROM `chief` WHERE id_users="' . $idUser . '"');
        return $query->getResult();
    }

    /**
     * Check if a user is an admin according to its ID
     * int $idUser
     */
    public function isAdmin($idUser)
    {
        $query = $this->db->query('SELECT * FROM `admin` WHERE id_users="' . $idUser . '"');
        return $query->getResult();
    }

    /**
     * Check if a user is a moderator according to its ID
     * int $idUser
     */
    public function isModerator($idUser)
    {
        $query = $this->db->query('SELECT * FROM `moderator` WHERE id_users="' . $idUser . '"');
        return $query->getResult();
    }
}
