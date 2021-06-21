<?php

namespace App\Libraries;

/**
 * Rules defined for regex
 */
class MyRules
{
    /**
     * This is the regex method to check name
     */
    public function regex_check_name($str)
    {
        if (!preg_match("/^[a-zA-ZÀ-ÿ ,.'-]{2,20}+$/i", $str)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * This is the regex method to check password
     */
    public function regex_check_password($str)
    {
        if (!preg_match("/^(?=.*?[A-Z])(?=(.*[a-z]))(?=(.*[\d]))(?=(.*[\W]))(?!.*\s).{12,}$/", $str)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * This is the regex method to check username
     */
    public function regex_check_username($str)
    {
        if (!preg_match("/^[a-zA-ZÀ-ÿ0-9._-]{7,20}$/", $str)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * This is the regex method to check the postcode
     */
    public function regex_check_postcode($str)
    {
        if (!preg_match("/^[0-9]{5}$/", $str)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}