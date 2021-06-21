<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\UnitMeasureModel;
use App\Models\ProductModel;

class RecipeIngredient extends Entity {     

    /**
     * Get the unit measure
     */
    public function getUnitMeasure(){
        $unitModel = new UnitMeasureModel();
        $unit = $unitModel -> find($this->id_unit_measures);
        return $unit;
    }

    /**
     * Get the product
     */
    public function getProduct(){
        $ingModel = new ProductModel();
        $ing = $ingModel -> find($this->id_ingredients);
        return $ing;
    }
        
}

