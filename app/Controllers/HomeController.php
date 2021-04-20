<?php

namespace App\Controllers;
use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\PictureModel;
use App\Entities\Recipe;

class HomeController extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	public function home()
    {
		$tagModel = new TagModel();
		$recipeModel = new RecipeModel();
		$pictureModel= new PictureModel();
		$tags = $tagModel -> findAll();
		shuffle($tags);
		$tagsSliced=array_slice($tags,0,4);
		
		$index=0;
		foreach ($tagsSliced as $tag){
			$recipe= $recipeModel -> getOneRecipebyTag($tag->name);
			var_dump($recipe);
			if ($recipe!=null){
				$picture = $pictureModel ->find($recipe[0]->id_pictures);
				if ($picture!=null){
					$data["tags"][$index]["picture"]=$picture[0]->name.".".$picture[0]->extension;
				}
			}			
			$index++;
		}
		$data["tags"] = $tagsSliced;
        $data["base_dir"]=__DIR__;
        $data["loc"]="Home";
		
		var_dump($tagsSliced);
		$recipe= $recipeModel -> getOneRecipebyTag("easy");
		$data["recipe"]=$recipe;
		
        return $this->twig->render("pages/home", $data);
    }
}
