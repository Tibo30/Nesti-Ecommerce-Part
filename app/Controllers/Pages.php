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
        return $this->twig->render("pages/home");
    }

    public function about()
    {
        return $this->twig->render("pages/about");
    }
}