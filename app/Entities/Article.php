<?php
namespace App\Entities;
use CodeIgniter\Entity;
use App\Models\PictureModel;
use App\Models\UnitMeasureModel;
use App\Models\IngredientModel;

class Article extends Entity
{

    public function getPicture(){

        $pictureModel = new PictureModel();
        $picture = $pictureModel -> find($this->id_pictures);
        return $picture;
    }

    public function getUnitMeasure(){
        $unitModel = new UnitMeasureModel();
        $unit = $unitModel -> find($this->id_unit_measures);
        return $unit;
    }

    public function getIngredient(){
        $ingModel = new IngredientModel();
        $ing = $ingModel -> find($this->id_products);
        return $ing;
    }

}
