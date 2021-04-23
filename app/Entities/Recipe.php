<?php
namespace App\Entities;
use CodeIgniter\Entity;
use App\Models\TagModel;
use App\Models\PictureModel;

class Recipe extends Entity
{

    public function getTags(){
        $tagModel = new TagModel();
        $tags = $tagModel -> tagsByRecipe($this->id_recipes);
        return $tags;
    }

    public function getPicture(){

        $pictureModel = new PictureModel();
        $picture = $pictureModel -> find($this->id_pictures);
        return $picture;
    }

}
