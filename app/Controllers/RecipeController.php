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
    public function recipes()
    {
        helper('form');
        $model = new RecipeModel();
        $pictureModel = new PictureModel();
        $tagModel = new TagModel();
        $tags = $tagModel->findAll();
        $recipes = $model->findAll();

        $data["loc"] = "Recipes";
        $data["recipes"] = $recipes;
        $data["tags"] = $tags;
        return $this->twig->render("pages/recipes.html", $data);
    }

    public function recipe($idRecipe)
    {
        helper('form');
        $model = new RecipeModel();
        $gradeModel = new GradeModel();
        $recipeIngredientModel = new RecipeIngredientModel();
        $paragraphModel = new ParagraphModel();
        $commentModel = new CommentModel();
        $recipe = $model->find($idRecipe);
        $grades = $gradeModel -> where('id_recipes',$idRecipe) ->findAll();
        $totalGrades = 0;
        foreach($grades as $grade){
            $totalGrades+=$grade->grade;
        }

        $averageGrade = null;
        if (count($grades)>0){
            $averageGrade = $totalGrades/count($grades);
        }

        $listRecipesIng = $recipeIngredientModel -> getRecipeIngredients($idRecipe);
        $recipesIngObjects = [];
        foreach($listRecipesIng as $ingredient){
            $recipesIngObject= new RecipeIngredient(get_object_vars($ingredient));
            $recipesIngObjects[]=$recipesIngObject;
        }

        $listParagraphs = $paragraphModel -> getParagraphs($idRecipe);
        $listParagraphsObject = [];
        foreach($listParagraphs as $paragraph){
            $paragraphsObject= new Paragraph(get_object_vars($paragraph));
            $listParagraphsObject[]=$paragraphsObject;
        }

        $listComments = $commentModel->where("id_recipes",$idRecipe) -> findAll();
       
        $data["loc"] = "Recipe";
        $data["recipe"] = $recipe;
        $data["recipeIngredients"] = $recipesIngObjects;
        $data["paragraphs"] = $listParagraphsObject;
        $data["comments"] = $listComments;
        $data["grade"] = $averageGrade;
        return $this->twig->render("pages/recipe.html", $data);
    }

}
