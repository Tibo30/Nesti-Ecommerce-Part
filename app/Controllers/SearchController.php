<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Entities\Recipe;

use App\Models\ArticleModel;
use App\Entities\Article;

use App\Models\ProductModel;


class SearchController extends BaseController
{

    /**
     * Get to the search page with results
     */
    public function search()
    {

        $searchWord = filter_input(INPUT_POST, "search-bar", FILTER_SANITIZE_STRING);

        $recipeModel = new RecipeModel();
        $articleModel = new ArticleModel();
        $productModel = new ProductModel();
        $articles = null;
        $recipes = [];
        $recipeObjects = [];
        $articleObjects = [];

        $products = $productModel->searchProduct($searchWord);
        if (count($products) > 0) {
            foreach ($products as $product) {
                $articles = $articleModel->where('id_products', $product->id_products)->where("state", "a")->findAll();
                foreach ($articles as $article) {
                    $articleObjects[] = $article;
                }
            }
        }

        $recipes = $recipeModel->searchRecipe($searchWord);

        foreach ($recipes as $recipe) {
            if ($recipe->state == "a") {
                $recipeObjects[] = new Recipe(get_object_vars($recipe));
            }
        }

        $data["loc"] = "Search";
        $data["recipes"] = $recipeObjects;
        $data["articles"] = $articleObjects;
        return $this->twig->render("pages/search.html", $data);
    }
}
