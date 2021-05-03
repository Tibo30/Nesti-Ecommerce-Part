<?php

namespace App\Libraries;

class MyRules
{
    public function regex_check_name($str)
    {
        if (!preg_match("/^[a-zA-ZÀ-ÿ ,.'-]{3,20}+$/i", $str)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function regex_check_password($str)
    {
        if (!preg_match("/^(?=.*?[A-Z])(?=(.*[a-z]))(?=(.*[\d]))(?=(.*[\W]))(?!.*\s).{12,}$/", $str)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function regex_check_username($str)
    {
        if (!preg_match("/^[a-zA-ZÀ-ÿ0-9._-]{7,20}$/", $str)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function regex_check_postcode($str)
    {
        if (!preg_match("/^[0-9]{5}$/", $str)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}