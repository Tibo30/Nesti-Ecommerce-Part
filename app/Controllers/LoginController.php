<?php

namespace App\Controllers;
use App\Models\UserModel;

class LoginController extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

    /**
     * Get to login page
     */
	public function login()
    {
		
        $data["base_dir"]=__DIR__;
        $data["loc"]="Login";
		
        return $this->twig->render("pages/login.html", $data);
    }

    /**
     * Get to register page
     */
    public function register()
    {
		
        $data["base_dir"]=__DIR__;
        $data["loc"]="Register";
		
        return $this->twig->render("pages/register.html", $data);
    }
}
