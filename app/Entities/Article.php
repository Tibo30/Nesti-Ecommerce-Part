<?php
namespace App\Entities;
use CodeIgniter\Entity;
use App\Models\PictureModel;
use App\Models\UnitMeasureModel;
use App\Models\IngredientModel;
use App\Models\LotModel;
use App\Models\OrderLineModel;

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

    public function getStock()
    {
        $lotModel = new LotModel();
        $orderLineModel = new OrderLineModel();
        $orderLines = $orderLineModel->where("id_article",$this->id_article)->findAll(); // get all the order lines for an article
        $lots = $lotModel->where("id_article",$this->id_article)->findAll(); // get all the lots for an article
        $quantityOrdered = 0;
        $quantityBought=0;
        foreach ($orderLines as $orderLine) {
            $quantityOrdered += $orderLine->quantity_ordered;
        }
        foreach($lots as $lot){
            $quantityBought += $lot->bought_quantity;
        }
        $stock=$quantityBought-$quantityOrdered;
        return $stock;
    }

    public function getName(){
        $name=$this->quantity_per_unit." ".$this->getUnitMeasure()->name." of ".$this->getIngredient()->product_name;

        return $name;
    }

}
