<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\PictureModel;

use App\Entities\Recipe;

class AjaxController extends BaseController
{

    /**
     * Recu depuis une requete Ajax
     * @return void
     */
    public function recipesTagged()
    {
        $data = [];
        $data['success'] = false;

        $model = new RecipeModel();

        $tags = json_decode($this->request->getPost('tags'));

        // rafraichissement du token CSRF
        $data['csrf_token'] = csrf_hash();

        if (count($tags)>0){
            $recipes = $model->getRecipesbyTags($tags);
        } else {
            $recipes = $model->findAll();
        }
        
        
        $html="";
        foreach($recipes as $recipe){
            if (count($tags)>0){
                $recipeObject = new Recipe(get_object_vars($recipe));
            } else {
                $recipeObject=$recipe;
            }
            $picture = $recipeObject->getPicture();
            $html.='<div class="recipe-card">'.
            '<img class="recipe-img" src="https://jolivet.needemand.com/realisations/nesti-admin/public/pictures/pictures/'.$picture->name.".".$picture->extension .'" alt="Card image cap">'.
            '<div class="recipe-card-body"><h5 class="recipe-card-title">'.$recipeObject->recipe_name.'</h5><a href=""><button class="recipe-btn-see">See Recipe</button>'.
            '</a></div></div>';
        }

        $data["recipes"]=$recipes;
        $data['success'] = true;
        $data["html"]=$html;

        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }
}
