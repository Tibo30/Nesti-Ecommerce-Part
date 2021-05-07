<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Entities\Recipe;
use App\Entities\stdClass;

use App\Models\ArticleModel;
use App\Entities\Article;

use App\Models\ProductModel;

use App\Models\TagModel;

use App\Models\RecipeIngredientModel;


class SuggestionsController extends BaseController
{
    

    public function suggestions()
    {
        helper('form');
        $modelProduct = new ProductModel();

        $products = $modelProduct->findAll();
        
        $ingredients=[];
        foreach($products as $product){
            if ($product->isIngredient()){
                $ingredients[]=$product;
            }
        }

        usort($ingredients, function ($r1, $r2) {  // sort the array ASC according to the product name
            return $r1->product_name <=> $r2->product_name;
        });

       $resultsIngredient = [];
       foreach ($ingredients as $ingredient){
           $resultIngredient = (object)[];
           $resultIngredient->ingredientId=$ingredient->id_products;
           $resultIngredient->name=$ingredient->product_name;
           $resultIngredient->url=$ingredient->getPictureName();
           $resultsIngredient[]=$resultIngredient;
       }

       $model = new RecipeModel();
       $recipes = $model->findAll();

       $recipeIngredientModel = new RecipeIngredientModel();

       $resultsRecipe = [];
       foreach ($recipes as $recipe){
           $resultRecipe = (object)[];
           $resultRecipe->recipeId=$recipe->id_recipes;
           
           $listRecipesIng = $recipeIngredientModel->where('id_recipes',$recipe->id_recipes)->findAll(); // get all the recipe ingredients for a recipe. Return array of object
           $listIngName=[];
           foreach($listRecipesIng as $recipesIng){
               $listIngName[]=$recipesIng->getProduct()->product_name;
           }
           $resultRecipe->ingredients=$listIngName;
           $resultsRecipe[]=$resultRecipe;
       }




        $data["loc"] = "Suggestions";
        $data["ingredientsJSON"]=$resultsIngredient;
        $data["recipesJSON"]=$resultsRecipe;
        return $this->twig->render("pages/suggestions.html", $data);
    }

    
    /**
     * get validRecipes from suggestions
     * @return void
     */
    public function recipesSuggestions()
    {
        helper('form');
        $tagModel = new TagModel();
        $tags = $tagModel->findAll();

        $recipeModel = new RecipeModel();

        $validRecipes = json_decode($this->request->getPost('validRecipes')); // get the validRecipes

        $recipes=[];
        foreach($validRecipes as $validRecipe){
            $recipes[]= $recipeModel->find($validRecipe->recipeId);
        }

        $data["loc"] = "Recipes";
        $data["recipes"] = $recipes;
        $data["tags"] = $tags;
        return $this->twig->render("pages/recipes.html", $data);

    }


    
}
