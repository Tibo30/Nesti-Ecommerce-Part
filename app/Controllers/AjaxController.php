<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\PictureModel;

use App\Entities\Recipe;

class AjaxController extends BaseController
{

    /**
     * Get all the recipes according to the tags selected (ajax request)
     * @return void
     */
    public function recipesTagged()
    {
        $data = [];
        $data['success'] = false;

        $model = new RecipeModel();

        $tags = json_decode($this->request->getPost('tags')); // get the tags from the post

        // refresh CSRF token
        $data['csrf_token'] = csrf_hash();


        if (count($tags)>0){
            $recipes = $model->getRecipesbyTags($tags); // method that get all the recipes from tags selected. Return an array of object
        } else {
            $recipes = $model->findAll(); // if there is no tag selected, we display all the recipes. Return an array of recipe object
        }
        
        $html="";
        foreach($recipes as $recipe){
            if (count($tags)>0){
                $recipeObject = new Recipe(get_object_vars($recipe)); // change the array of object to array of recipe object.
            } else {
                $recipeObject=$recipe;
            }
            $picture = $recipeObject->getPicture();
            $html.='<div class="recipe-card">'.
            '<img class="recipe-img" src="https://jolivet.needemand.com/realisations/nesti-admin/public/pictures/pictures/'.$picture->name.".".$picture->extension .'" alt="Card image cap">'.
            '<div class="recipe-card-body"><h5 class="recipe-card-title">'.$recipeObject->recipe_name.'</h5><a href="'.base_url("/recipe/".$recipeObject->id_recipes).'"><button class="recipe-btn-see">See Recipe</button>'.
            '</a></div></div>'; // we prepare the updated html (cards)
        }

        $data["recipes"]=$recipes;
        $data['success'] = true;
        $data["html"]=$html;

        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }
}
