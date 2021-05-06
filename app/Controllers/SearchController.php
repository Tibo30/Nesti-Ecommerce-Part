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
        //    $req = self::$_bdd->prepare('SELECT * FROM lots WHERE received_date LIKE :date"%"');
        var_dump($searchWord);

        $recipeModel = new RecipeModel();
        $articleModel = new ArticleModel();
        $productModel = new IngredientModel();
        $articles=[];
        $recipes=[];

        $products = $productModel->searchProduct($searchWord);
        if (count($products)>0){
            foreach($products as $product){
                $articles[]=$articleModel->where('id_products',$product->id_products)->findAll();
            }
        }

        $recipes = $recipeModel->searchRecipe($searchWord);

        var_dump($products);
        var_dump($articles);
        var_dump($recipes);


        $data["loc"] = "Search";
        // $data["recipes"] = $recipes;
        // $data["articles"] = $articles;
        return $this->twig->render("pages/search.html", $data);
    }


    
}
