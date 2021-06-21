<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\ProductModel;
use App\Models\ArticleModel;

class Product extends Entity
{

    /**
     * Check if the product is an ingredient
     */
    public function isIngredient()
    {
        $productModel = new ProductModel();
        $ing = false;
        $datas = $productModel->isIngredient($this->id_products);
        if (count($datas) > 0) {
            $ing = true;
        }
        return $ing;
    }

    /**
     * Get the name (name+extension) of the picture
     */
    public function getPictureName()
    {
        $pictureName = "nopicture.png";
        $articleModel = new ArticleModel();
        $articles = $articleModel->where("id_products", $this->id_products)->findAll();

        if (count($articles) > 0) {

            if ($articles[0]->getPicture() != null) {
                $pictureName = $articles[0]->getPicture()->name . "." . $articles[0]->getPicture()->extension;
            }
        }
        return $pictureName;
    }
}
