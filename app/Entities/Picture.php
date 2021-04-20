<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Picture extends Entity {     
        protected $attributes = [
            'id_pictures' => null,
            'creation_date' => null,
            'name' => null,        
            'extension' => null,
        ];
}

