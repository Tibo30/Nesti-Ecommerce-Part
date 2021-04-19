<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function home()
    {
        $data["base_dir"]=__DIR__;
        $data["loc"]="Home";
        return $this->twig->render("pages/home", $data);
    }

    public function about()
    {
        return $this->twig->render("pages/about");
    }
}