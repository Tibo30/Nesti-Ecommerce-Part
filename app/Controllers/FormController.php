<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class FormController extends Controller
{
    public function index()
    {
        helper(['form', 'url']);

        // plusieurs consignes sont séparées pas un "pipe"        
        $rules = [
            'username' => 'required',
            'password' => 'required|numeric|max_length[10]',
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            echo view('form/signup', [
                'validation' => $this->validator,
            ]);
        } else {
            echo view('form/success');
        }
    }
}
