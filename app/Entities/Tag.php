<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Tag extends Entity {     
        protected $attributes = [
            'id_tag' => null,
            'name' => null,        // Represents a username
        ];
}

