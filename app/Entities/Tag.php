<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\RecipeModel;
use App\Models\TaggedModel;
use App\Entities\Recipe;

class Tag extends Entity
{

    /**
     * Get a recipe for the tag
     */
    public function getOneRecipe()
    {
        $recipeModel = new RecipeModel();
        $taggedModel = new TaggedModel();

        $recipesTagged = $taggedModel->where("id_tag", $this->id_tag)->findAll(); // get all the recipes for a tag. Return an array of object

        $recipes = [];
        foreach ($recipesTagged as $recipeTagged) {
            $recipe = $recipeModel->find($recipeTagged->id_recipes);
            if ($recipe->state == "a" && $recipe->getPicture() != null) {
                $recipes[] = $recipe;
            }
        }

        shuffle($recipes);
        if (count($recipes) > 0) {
            $recipe = $recipes[0];
        } else {
            $recipe = null;
        }

        return $recipe;
    }
}
