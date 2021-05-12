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
		
		$data["tags"] = $tagsSliced;
        $data["base_dir"]=__DIR__;
        $data["loc"]="Home";
		
        return $this->twig->render("pages/home.html", $data);
    }
}
