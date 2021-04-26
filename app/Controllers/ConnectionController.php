<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Entities\User;
use App\Models\ConnectionModel;
use App\Models\UserModel;

class ConnectionController extends BaseController
{


    public function index()
    {
        helper($this->helpers);
        $data["base_dir"] = __DIR__;
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true) {
            $data["loc"] = "Dashboard";
            return $this->twig->render("pages/dashboard.html", $data);
        } else {
            $data["loc"] = "Login";
            return $this->twig->render("pages/login.html", $data);
        }
    }

    public function checkLogin()
    {
        helper($this->helpers);
        $data["base_dir"] = __DIR__;
        $data['success'] = false;


        $emailPassword = filter_input(INPUT_POST, "emailUsername", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

        $connectionModel = new ConnectionModel();

        $user =  $connectionModel->checkUser($emailPassword);

        $activUser = new User();
        if (count($user) > 0) {
            $activUser = new User(get_object_vars($user[0]));
        }

        $activeUserId = $activUser->id_users;
        $isVerified = password_verify($password, $activUser->password);


        if ($isVerified && $activeUserId != 0) {
            if ($activUser->state == "a") {

                var_dump($activUser->id_users);
                $dataSession = [
                    'lastname' => $activUser->lastname,
                    'firstname' => $activUser->firstname,
                    'id' => $activUser->id_users,
                    'logged' => "yes",
                    'logged_in' => true
                ];

                $this->session->set($dataSession);

                $data['success'] = true;

                $data["loc"] = "Dashboard";
                return $this->twig->render("pages/dashboard.html", $data);
            } else {
                $errorEmail = 'Your account isn\'t active ';
                $errorMessages = ['emailUsername' => $errorEmail];
                $data['errorMessages'] = $errorMessages;
                $data["loc"] = "Login";
                return $this->twig->render("pages/login.html", $data);
            }
        } else {
            $errorEmail = "";
            $errorPassword = "";
            if ($activeUserId == null) {
                $errorEmail = "The Email or Username used is not register";
            } else {
                if ($isVerified == false) {
                    $errorPassword = "The password is incorrect";
                }
            }
            $errorMessages = ['emailUsername' => $errorEmail, 'password' => $errorPassword];
            $data['errorMessages'] = $errorMessages;
            $data["loc"] = "Login";
            return $this->twig->render("pages/login.html", $data);
        }
    }

    public function disconnect()
    {
        $dataSession = [
            'lastname' => null,
            'firstname' => null,
            'id' => null,
            'logged' => "no",
            'logged_in' => false
        ];
        $this->session->set($dataSession);
        $data["loc"] = "Login";
        return $this->twig->render("pages/login.html", $data);
    }
}
