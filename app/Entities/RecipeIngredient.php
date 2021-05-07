<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\UnitMeasureModel;
use App\Models\ProductModel;

class RecipeIngredient extends Entity {     

    public function getUnitMeasure(){
        $unitModel = new UnitMeasureModel();
        $unit = $unitModel -> find($this->id_unit_measures);
        return $unit;
    }

    public function getProduct(){
        $ingModel = new ProductModel();
        $ing = $ingModel -> find($this->id_ingredients);
        return $ing;
    }
        
}

