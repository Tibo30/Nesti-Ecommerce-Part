<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Entities\User;



class CartController extends BaseController
{
    /**
     * cart page
     */
    public function cart()
    {
        $data["loc"] = "Cart";
        return $this->twig->render("pages/cart.html", $data);
    }

    /**
     * pay page
     */
    public function pay()
    {

        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){ // if the user is connected
            $userModel = new UserModel();
            $user = $userModel->find($_SESSION['id']);
            $data["loc"] = "Pay";
            $data["user"] = $user;
            return $this->twig->render("pages/pay.html", $data);
        } else { // else go to login
            $data["base_dir"]=__DIR__;
            $data["loc"]="Login";
            return $this->twig->render("pages/login.html", $data);
        }
       
    }


    
}
