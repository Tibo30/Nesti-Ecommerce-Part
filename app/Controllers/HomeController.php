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
		
		$tag_pictures=[];
		$index=0;
		foreach ($tagsSliced as $tag){
			$recipe= $recipeModel -> getOneRecipebyTag($tag->name);
			if ($recipe!=null){
				$picture = $pictureModel ->find($recipe[0]->id_pictures);
				// print_r($picture);
				// if($index==0 || $index==1 ){
				// 	print_r($picture);
				// 	print_r($picture->name);
				// }
				
				if ($picture!=null){
					$tag_pictures[$index]=$picture->name.".".$picture->extension;
				} else {
					$tag_pictures[$index]="null";
				}
			}			
			$index++;
		}
		// var_dump($tag_pictures);

		$data["pictures"]=$tag_pictures;
		$data["tags"] = $tagsSliced;
        $data["base_dir"]=__DIR__;
        $data["loc"]="Home";
		
		// var_dump($tagsSliced);
		$recipe= $recipeModel -> getOneRecipebyTag("easy");
		$data["recipe"]=$recipe;
		
        return $this->twig->render("pages/home", $data);
    }
}
