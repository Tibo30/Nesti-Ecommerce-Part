<?php

namespace App\Entities;

use CodeIgniter\Entity;
use App\Models\UserModel;

class Comment extends Entity {     

    public function getUser(){
        $userModel = new UserModel();
        $user = $userModel -> find($this->id_users);
        return $user;
    }    

}

