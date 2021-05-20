<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Models\ProductModel;
use App\Models\ParagraphModel;
use App\Models\TagModel;
use App\Models\TokenModel;
use App\Entities\Token;

class ApiController extends BaseController
{

    public function index()
    {
        return view('api/api_help');
    }

    public function recipes($token)
    {
        $tokenModel = new TokenModel();
        $tokenBdd = $tokenModel->find(1);
        if ($token == $tokenBdd->token_value) {
            $model = new RecipeModel();
            $recipes = $model->findAllForApi();
            header('Content-Type: application/json');
            echo json_encode($recipes);
        } else {
            header('Content-Type: application/json');
            echo json_encode('you don\'t have the rights');
        }
        die;
    }

    public function category($token, $cat)
    {
        $tokenModel = new TokenModel();
        $tokenBdd = $tokenModel->find(1);
        if ($token == $tokenBdd->token_value) {
            $model = new RecipeModel();
            $recipes = $model->findCat($cat);
            header('Content-Type: application/json');
            echo json_encode($recipes);
        } else {
            header('Content-Type: application/json');
            echo json_encode('you don\'t have the rights');
        }
        die;
    }

    public function categories($token)
    {
        $tokenModel = new TokenModel();
        $tokenBdd = $tokenModel->find(1);
        if ($token == $tokenBdd->token_value) {
            $model = new TagModel();
            $tags = $model->findAll();
            header('Content-Type: application/json');
            echo json_encode($tags);
        } else {
            header('Content-Type: application/json');
            echo json_encode('you don\'t have the rights');
        }
        die;
    }

    public function recipe($token, $idRecipe)
    {
        $tokenModel = new TokenModel();
        $tokenBdd = $tokenModel->find(1);
        if ($token == $tokenBdd->token_value) {
            $modelRecipe = new RecipeModel();
            $modelProduct = new ProductModel();
            $modelParagraph = new ParagraphModel();

            $recipe = $modelRecipe->find($idRecipe);
            $products = $modelProduct->getIngredients($idRecipe);


            $ingredients = [];
            foreach ($products as $product) {

                $ingredients[] = $product;
            }

            $paragraphs = $modelParagraph->getParagraphs($idRecipe);
            $recipe->paragraphs = $paragraphs;
            $recipe->ingredients = $ingredients;
            header('Content-Type: application/json');
            echo json_encode($recipe);
        } else {
            header('Content-Type: application/json');
            echo json_encode('you don\'t have the rights');
        }
        die;
    }

    public function searchRecipe($token, $name)
    {
        $tokenModel = new TokenModel();
        $tokenBdd = $tokenModel->find(1);
        if ($token == $tokenBdd->token_value) {
            $modelRecipe = new RecipeModel();
            //$recipes =  $modelRecipe->like('recipe_name', $name);   
            $recipes =  $modelRecipe->findRecipe($name);
            header('Content-Type: application/json');
            echo json_encode($recipes);
        } else {
            header('Content-Type: application/json');
            echo json_encode('you don\'t have the rights');
        }
        die;
    }
}
