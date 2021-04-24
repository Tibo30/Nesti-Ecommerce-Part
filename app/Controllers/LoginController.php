<?php

namespace App\Controllers;
use App\Models\UserModel;

class LoginController extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	public function login()
    {
		
        $data["base_dir"]=__DIR__;
        $data["loc"]="Login";
		
        return $this->twig->render("pages/login.html", $data);
    }

    public function register()
    {
		
        $data["base_dir"]=__DIR__;
        $data["loc"]="Register";
		
        return $this->twig->render("pages/register.html", $data);
    }
}
