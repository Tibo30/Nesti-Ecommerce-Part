<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Token;

class TokenModel extends Model
{

    protected $table = 'token'; // nom de la table
    protected $primaryKey = 'id_token';
    protected $allowedFields = ['id_token','application','token_value']; // Nom des colonnes autorisées
    protected $returnType = Token::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation     = true;
}
