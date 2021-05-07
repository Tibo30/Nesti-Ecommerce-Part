<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Entities\Recipe;

use App\Models\ArticleModel;
use App\Entities\Article;

use App\Models\IngredientModel;


class SearchController extends BaseController
{
    

    public function search()
    {

        $searchWord = filter_input(INPUT_POST, "search-bar", FILTER_SANITIZE_STRING); 

        $recipeModel = new RecipeModel();
        $articleModel = new ArticleModel();
        $productModel = new IngredientModel();
        $articles=null;
        $recipes=[];
        $recipeObjects=[];
        $articleObjects=[];

        $products = $productModel->searchProduct($searchWord);
        if (count($products)>0){
            foreach($products as $product){
                $articles=$articleModel->where('id_products',$product->id_products)->findAll();
                foreach($articles as $article){
                    $articleObjects[]=$article;
                }
            }
        }
    
        $recipes = $recipeModel->searchRecipe($searchWord);

        foreach ($recipes as $recipe){
            $recipeObjects[] = new Recipe(get_object_vars($recipe));
        }

        $data["loc"] = "Search";
        $data["recipes"] = $recipeObjects;
        $data["articles"] = $articleObjects;
        return $this->twig->render("pages/search.html", $data);
    }


    
}
