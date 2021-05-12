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
        // $articles = $model->orderBy("id_products","asc")->findAll();
        $articles = $model->where("state","a")->findAll();
        usort($articles, function ($r1, $r2) { // sort the array ASC according to the product name of the article
            return $r1->getProduct()->product_name <=> $r2->getProduct()->product_name;
        });

        $data["loc"] = "Articles";
        $data["articles"] = $articles;
        return $this->twig->render("pages/articles.html", $data);
    }

    
    /**
     * Get the article information
     */
    public function article($idArticle)
    {
        helper('form');

        $articleModel = new ArticleModel();
        $recipeIngredientModel = new RecipeIngredientModel();
        $recipeModel = new RecipeModel();

        $article = $articleModel->find($idArticle); // get the article object
        if ($article!=null){

            $idIngredient = $article->getProduct()->id_products; // get the id of the ingredient for this article

            $recipesIng = $recipeIngredientModel->where("id_ingredients",$idIngredient)->findAll(); // get all the recipes ing obj for this ingredient
    
            $recipes=[];
            foreach($recipesIng as $ing){ // get all the recipes for this ingredient
                $recipes[]=$recipeModel->find($ing->id_recipes);
            }    
            
            $data["loc"] = "Article";
            $data["article"] = $article;
            $data["recipes"] = $recipes;
            return $this->twig->render("pages/article.html", $data);
        } else {
            return redirect()->back();
        }
        
    }

  
}
