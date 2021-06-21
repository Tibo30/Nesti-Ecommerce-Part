<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\PictureModel;
use App\Models\UnitMeasureModel;
use App\Models\ProductModel;
use App\Models\LotModel;
use App\Models\ArticleModel;
use App\Models\OrderLineModel;

class Article extends Entity
{
/**
 * Get the picture of the article
 */
    public function getPicture()
    {

        $pictureModel = new PictureModel();
        if ($this->id_pictures != null) {
            $picture = $pictureModel->find($this->id_pictures);
        } else {
            $picture = null;
        }
        return $picture;
    }

    /**
     * Get the unit measure of the article
     */
    public function getUnitMeasure()
    {
        $unitModel = new UnitMeasureModel();
        $unit = $unitModel->find($this->id_unit_measures);
        return $unit;
    }

    /**
     * get the product of the article
     */
    public function getProduct()
    {
        $ingModel = new ProductModel();
        $ing = $ingModel->find($this->id_products);
        return $ing;
    }

    /**
     * Get the stock of the article
     */
    public function getStock()
    {
        $lotModel = new LotModel();
        $orderLineModel = new OrderLineModel();
        $orderLines = $orderLineModel->where("id_article", $this->id_article)->findAll(); // get all the order lines for an article
        $lots = $lotModel->where("id_article", $this->id_article)->findAll(); // get all the lots for an article
        $quantityOrdered = 0;
        $quantityBought = 0;
        foreach ($orderLines as $orderLine) {
            $quantityOrdered += $orderLine->quantity_ordered;
        }
        foreach ($lots as $lot) {
            $quantityBought += $lot->bought_quantity;
        }
        $stock = $quantityBought - $quantityOrdered;
        return $stock;
    }

    /**
     * Get the name of the article
     */
    public function getName()
    {
        $name = $this->quantity_per_unit . " " . $this->getUnitMeasure()->name . " of " . $this->getProduct()->product_name;

        return $name;
    }

    /**
     * Get the last price of the article
     */
    public function getLastPrice()
    {

        $price = "";
        $articleModel = new ArticleModel();
        $priceObject = $articleModel->getLastPrice($this->id_article);
        if (count($priceObject) > 0) {
            $price = $priceObject[0]->price;
        }
        return floatval($price);
    }
}
