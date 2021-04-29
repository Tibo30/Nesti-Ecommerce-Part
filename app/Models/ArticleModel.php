<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Article;

class ArticleModel extends Model
{

    protected $table = 'articles'; // nom de la table
    protected $primaryKey = 'id_article';
    protected $allowedFields = ['id_article','quantity_per_unit','state','creation_date','update_date','id_unit_measures','id_products','id_pictures','user_article_name']; // Nom des colonnes autorisées
    protected $returnType = Article::class; // Type de retour
    protected $useTimestamps = false; // Utilisation du timestamps
    protected $skipValidation  = true;

    public function getLastPrice($idArticle){
        $query = $this->db->query('SELECT price FROM article_price WHERE id_article="' . $idArticle . '" ORDER BY application_date DESC LIMIT 1');
        return $query->getResult();
    }

    
}
