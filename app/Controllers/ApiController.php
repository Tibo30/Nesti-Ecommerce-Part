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
        $tokenBdd = $tokenModel->where('token_value', $token)->find();
        header('Content-Type: application/json');
        if ($tokenBdd != null) {
            $model = new RecipeModel();
            $recipes = $model->findAllForApi();
            echo json_encode($recipes);
        } else {
            echo json_encode('you don\'t have the rights');
        }
        die;
    }

    public function category($token, $cat)
    {
        $tokenModel = new TokenModel();
        $tokenBdd = $tokenModel->where('token_value', $token)->find();
        header('Content-Type: application/json');
        if ($tokenBdd != null) {
            $model = new RecipeModel();
            $recipes = $model->findCat($cat);
            echo json_encode($recipes);
        } else {
            echo json_encode('you don\'t have the rights');
        }
        die;
    }

    public function categories($token)
    {
        $tokenModel = new TokenModel();
        $tokenBdd = $tokenModel->where('token_value', $token)->find();
        header('Content-Type: application/json');
        if ($tokenBdd != null) {
            $model = new TagModel();
            $tags = $model->findAll();
            echo json_encode($tags);
        } else {
            echo json_encode('you don\'t have the rights');
        }
        die;
    }

    public function recipe($token, $idRecipe)
    {
        $tokenModel = new TokenModel();
        $tokenBdd = $tokenModel->where('token_value', $token)->find();
        header('Content-Type: application/json');
        if ($tokenBdd != null) {
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
            echo json_encode($recipe);
        } else {
            echo json_encode('you don\'t have the rights');
        }
        die;
    }

    public function searchRecipe($token, $name)
    {
        $tokenModel = new TokenModel();
        $tokenBdd = $tokenModel->where('token_value', $token)->find();
        header('Content-Type: application/json');
        if ($tokenBdd != null) {
            $modelRecipe = new RecipeModel();
            $recipes =  $modelRecipe->findRecipe($name);
            echo json_encode($recipes);
        } else {
            echo json_encode('you don\'t have the rights');
        }
        die;
    }
}
