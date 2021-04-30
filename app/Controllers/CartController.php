<?php

namespace App\Controllers;

class CartController extends BaseController
{
    // protected $cart;
    // /**
    //  * 
    //  */
    // public function postCart()
    // {
       
    //     // refresh CSRF token
    //     $data['csrf_token'] = csrf_hash();
    //     $this->cart= $this->request->getPost('cart'); // get the cart from the post
    //     var_dump($this->cart);
    //     $data['success'] = true;
    //     header('Content-Type: application/json');
    //     echo json_encode($data);
    //     die;
    // }

    public function cart(){

        //var_dump($this->cart);
        $data["loc"] = "Cart";
        //$data["cart"] = $this->cart;
        return $this->twig->render("pages/cart.html", $data);
    }

    public function pay(){

        $data["loc"] = "Pay";
        return $this->twig->render("pages/pay.html", $data);
    }


  
}
