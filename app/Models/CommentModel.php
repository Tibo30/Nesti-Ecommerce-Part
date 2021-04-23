<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Comment;

class CommentModel extends Model
{

    protected $table = 'comments'; // nom de la table
    protected $primaryKey = 'id_comments';
    protected $allowedFields = ['id_comments','comment_title','comment_content','creation_date','state', 'id_recipes','id_moderator','id_users']; // Nom des colonnes autorisées
    protected $returnType = Comment::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;

    
}
