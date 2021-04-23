<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\RecipeModel;
use App\Entities\Recipe;

class Tag extends Entity
{
    // private Recipe $recipe;

    public function getOneRecipe()
    {
        $recipeModel = new RecipeModel();
        $recipes = $recipeModel->getRecipesbyTag($this->name);
        shuffle($recipes);
        $recipe = new Recipe(get_object_vars($recipes[0]));
        return $recipe;
    }
}
