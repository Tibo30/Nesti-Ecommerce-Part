<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\TaggedModel;
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
        $recipes = $model->where("state", "a")->findAll();

        $data["loc"] = "Recipes";
        $data["recipes"] = $recipes;
        $data["tags"] = $tags;
        return $this->twig->render("pages/recipes.html", $data);
    }

    /**
     * Get all the recipes according to a tag (selected in the home page)
     * int $tag
     */
    public function recipesByTag($tag)
    {
        helper('form');
        $model = new RecipeModel();
        $tagModel = new TagModel();

        $taggedModel = new TaggedModel();

        $tags = $tagModel->findAll();

        $recipesTagged = $taggedModel->where("id_tag", $tag)->findAll(); // get all the recipes for a tag. Return an array of object

        $recipes = [];

        foreach ($recipesTagged as $recipeTagged) {
            $recipe = $model->find($recipeTagged->id_recipes);
            if ($recipe->state == "a") {
                $recipes[] = $recipe;
            }
        }

        $tagChosen = $tagModel->find($tag);

        $data["loc"] = "Recipes";
        $data["recipes"] = $recipes;
        $data["tags"] = $tags;
        $data["tagChosen"] = $tagChosen->name;
        return $this->twig->render("pages/recipes.html", $data);
    }


    /**
     * Get the recipe information according to its ID
     * int $idRecipe
     */
    public function recipe($idRecipe)
    {
        helper('form');

        $model = new RecipeModel();
        $recipeIngredientModel = new RecipeIngredientModel();
        $paragraphModel = new ParagraphModel();
        $commentModel = new CommentModel();
        $recipe = $model->find($idRecipe); // get the recipe object


        $listRecipesIng = $recipeIngredientModel->where('id_recipes', $idRecipe)->findAll(); // get all the recipe ingredients for a recipe. Return array of object

        $listParagraphs = $paragraphModel->where('id_recipes', $idRecipe)->orderBy('order_paragraph', 'ASC')->findAll(); // get all the steps for a recipe. Return an array of object

        $listComments = $commentModel->where("id_recipes", $idRecipe)->where("state", "a")->findAll(); // get all the accepted comments for a recipe

        $data["loc"] = "Recipe";
        $data["recipe"] = $recipe;
        $data["recipeIngredients"] = $listRecipesIng;
        $data["paragraphs"] = $listParagraphs;
        $data["comments"] = $listComments;
        return $this->twig->render("pages/recipe.html", $data);
    }
}
