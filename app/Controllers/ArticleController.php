<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\RecipeModel;
use App\Models\PictureModel;
use App\Models\GradeModel;
use App\Models\RecipeIngredientModel;
use App\Models\ParagraphModel;
use App\Models\CommentModel;

use App\Entities\Recipe;
use App\Entities\RecipeIngredient;
use App\Entities\Paragraph;

class ArticleController extends BaseController
{
    /**
     * Get all articles
     */
    public function articles()
    {
        helper('form');
        $model = new ArticleModel();
        $articles = $model->findAll();

        $data["loc"] = "Articles";
        $data["articles"] = $articles;
        return $this->twig->render("pages/articles.html", $data);
    }

  
}
