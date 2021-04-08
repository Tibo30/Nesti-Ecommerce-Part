<?php
namespace App\Entities;
use CodeIgniter\Entity;


class Recipe extends Entity
{
    protected $attributes = [
        'id_recipes' => null,
        'creation_date' => null,        
        'recipe_name' => null,
        'difficulty' => null,
        'number_of_people' => null,
        'state' => null,
        'time' => null,
        'id_pictures' => null,
        'id_chief' => null,
        'paragraphs' => null,
        'ingredients' => null,
    ];
   
}
