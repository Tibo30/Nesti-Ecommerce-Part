<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Models\ProductModel;
use App\Models\ParagraphModel;

class ApiController extends BaseController
{

    public function index()
    {
        return view('api/api_help');
    }

    public function recipes()
    {
        $model = new RecipeModel();
        $recipes = $model->findAllForApi();
        header('Content-Type: application/json');
        echo json_encode($recipes);
        die;
    }

    public function category($cat)
    {
        $model = new RecipeModel();
        $recipes = $model->findCat($cat);
        header('Content-Type: application/json');
        echo json_encode($recipes);
        die;
    }

    public function recipe($idRecipe)
    {
        $modelRecipe = new RecipeModel();
        $modelProduct = new ProductModel();
        $modelParagraph = new ParagraphModel();

        $recipe = $modelRecipe->find($idRecipe);
        $products = $modelProduct->getIngredients($idRecipe); // need to add check if product is ingredient ??
        
        $ingredients=[];
        foreach($products as $product){
            if ($product->isIngredient()){
                $ingredients[]=$product;
            }
        }

        $paragraphs= $modelParagraph->getParagraphs($idRecipe);
        $recipe->paragraphs=$paragraphs;
        $recipe->ingredients=$ingredients;
        header('Content-Type: application/json');
        echo json_encode($recipe);
        die;
    }

    public function searchRecipe($name){
        $modelRecipe = new RecipeModel();
        //$recipes =  $modelRecipe->like('recipe_name', $name);   
        $recipes =  $modelRecipe->findRecipe($name);   
        header('Content-Type: application/json');
        echo json_encode($recipes);
        die;
    }
}
