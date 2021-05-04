<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CityModel;

use App\Entities\User;
use App\Entities\City;

class UserController extends BaseController
{
    public function createUser()
    {

        $data = [];
        $data["success"]=false;
        $data['csrf_token'] = csrf_hash();
        helper('form');

        if ($this->request->getMethod() == 'post') {

            $validation = \Config\Services::validation();

            $validation->setRules(
                [
                    'firstname' => 'required|regex_check_name',
                    'lastname' => 'required|regex_check_name',
                    'username'     => 'required|regex_check_username|is_unique[users.username]',
                    'password'     => 'required|regex_check_password',
                    'confirmPassword' => 'required|matches[password]',
                    'email'        => 'required|valid_email|is_unique[users.email]',
                    'address1' => 'required',
                    'postcode' => 'required|regex_check_postcode',
                    'city' => 'required',
                ],
                [   // Errors
                    'lastname' => [
                        'regex_check_name' => 'The lastname field is not valid!'
                    ],
                    'firstname' => [
                        'regex_check_name' => 'The firstname field is not valid!'
                    ],
                    'username' => [
                        'regex_check_username' => 'The username has to be between 7 to 20 alphanumeric characters("." "_" "-" accepted)',
                        'is_unique' => 'This username is already taken'
                    ],
                    'password' => [
                        'regex_check_password' => 'The password isn\'t strong enough or doesn\'t respect the conditions'
                    ],
                    'postcode' => [
                        'regex_check_postcode' => 'Please enter a valid postcode (5 digits)'
                    ],
                    'email' => [
                        'is_unique' => 'This email is already taken'
                    ],

                ]
            );

            $check = $validation->withRequest($this->request)->run(); // check the validation rules

            if (!$check) {
                $data['validation'] = $validation->getErrors();
            } else {
                $lastname = $this->request->getPost('lastname');
                $firstname = $this->request->getPost('firstname');
                $username = $this->request->getPost('username');
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $address1 = $this->request->getPost('address1');
                $address2 = $this->request->getPost('address2');
                $postcode = $this->request->getPost('postcode');
                $cityName = $this->request->getPost('city');

                $cityModel = new CityModel();
                $city = $cityModel->where("city_name", $cityName)->find();
                $cityId = 0;
                if (count($city) > 0) {
                    $cityId = $city[0]->id_city;
                } else {
                    $newCity = new City();
                    $newCity->fill(['city_name' => $cityName]);
                    $cityId = $cityModel->insert($newCity);
                }

                $newUser = new User();
                $newUser->fill([
                    'lastname' => $lastname,
                    'firstname' => $firstname,
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'address1' => $address1,
                    'address2' => $address2,
                    'postcode' => $postcode,
                    'id_city' => $cityId
                ]);
                $userModel = new UserModel();
                $userModel->insert($newUser);
                $data["city"]=$cityName;

                $data["user"]=$newUser;
                $data["success"]=true;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        die;
        
        // return $this->twig->render("pages/register.html", $data);
    }
}
