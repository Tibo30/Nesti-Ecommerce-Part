<?php
namespace App\Entities;
use CodeIgniter\Entity;


class Paragraph extends Entity
{
    protected $attributes = [
        'id_paragraph' => null,
        'content' => null,
        'order_paragraph' => null,
        'creation_date' => null,        
        'id_recipes' => null,
    ];

 
   
}
