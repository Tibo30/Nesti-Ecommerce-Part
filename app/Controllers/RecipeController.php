<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\PictureModel;
use App\Models\GradeModel;
use App\Models\RecipeIngredientModel;
use App\Models\ParagraphModel;
use App\Models\CommentModel;

use App\Entities\Recipe;
use App\Entities\RecipeIngredient;
use App\Entities\Paragraph;

class RecipeController extends BaseController
{
    /**
     * Get all recipes and tags
     */
    public function recipes()
    {
        helper('form');
        $model = new RecipeModel();
        $tagModel = new TagModel();
        $tags = $tagModel->findAll();
        $recipes = $model->where("state","a")->findAll();

        $data["loc"] = "Recipes";
        $data["recipes"] = $recipes;
        $data["tags"] = $tags;
        return $this->twig->render("pages/recipes.html", $data);
    }

    /**
     * Get all the recipes according to a tag (selected in the home page)
     */
    public function recipesByTag($tag)
    {
        helper('form');
        $tag=str_replace('_', ' ', $tag);
        $model = new RecipeModel();
        $tagModel = new TagModel();
        $tags = $tagModel->findAll();
        $recipes = $model->getRecipesbyTag($tag); // get all the recipes for a tag. Return an array of object
        $recipesObject = [];
        foreach ($recipes as $recipe) {
            $recipesObject[] = new Recipe(get_object_vars($recipe)); // change the array of object to array of recipe object
        }
        $data["loc"] = "Recipes";
        $data["recipes"] = $recipesObject;
        $data["tags"] = $tags;
        $data["tagChosen"] = $tag;
        return $this->twig->render("pages/recipes.html", $data);
    }


    /**
     * Get the recipe information
     */
    public function recipe($idRecipe)
    {
        helper('form');

        $model = new RecipeModel();
        $recipeIngredientModel = new RecipeIngredientModel();
        $paragraphModel = new ParagraphModel();
        $commentModel = new CommentModel();
        $recipe = $model->find($idRecipe); // get the recipe object
        

        $listRecipesIng = $recipeIngredientModel->where('id_recipes',$idRecipe)->findAll(); // get all the recipe ingredients for a recipe. Return array of object
      
        $listParagraphs = $paragraphModel->getParagraphs($idRecipe); // get all the steps for a recipe. Return an array of object
        $listParagraphsObject = [];
        foreach ($listParagraphs as $paragraph) {
            $paragraphsObject = new Paragraph(get_object_vars($paragraph)); // change the array of object to array paragraph of object
            $listParagraphsObject[] = $paragraphsObject;
        }

        $listComments = $commentModel->where("id_recipes", $idRecipe)->where("state","a")->findAll(); // get all the accepted comments for a recipe

        $data["loc"] = "Recipe";
        $data["recipe"] = $recipe;
        $data["recipeIngredients"] = $listRecipesIng;
        $data["paragraphs"] = $listParagraphsObject;
        $data["comments"] = $listComments;
        return $this->twig->render("pages/recipe.html", $data);
    }

    
}
