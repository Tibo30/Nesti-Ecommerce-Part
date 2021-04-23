<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\PictureModel;

use App\Entities\Recipe;

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

}
