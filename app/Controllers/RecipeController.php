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
        $model = new RecipeModel();
        $pictureModel = new PictureModel();
        $tagModel = new TagModel();
        $tags = $tagModel -> findAll();
        $recipes = $model->findAll();
        $recipes_pictures = [];
        $index = 0;
        foreach ($recipes as $recipe) {
            $picture = $pictureModel->find($recipe->id_pictures);
            if ($picture != null) {
                $recipes_pictures[$index] = $picture->name . "." . $picture->extension;
            } else {
                $recipes_pictures[$index] = "null";
            }
            $index++;
        }
        $data["loc"] = "Recipes";
        $data["recipes"] = $recipes;
        $data["pictures"] = $recipes_pictures;
        $data["tags"]=$tags;
        return $this->twig->render("pages/recipes.html", $data);
    }
}
