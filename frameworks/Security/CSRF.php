<?php
namespace RianBase\Security;

class CSRF {
    public static function getCSRFToken()
    {
        if(!isset($_SESSION['_rb_csrf_token']))
        {
            $_SESSION['_rb_csrf_token'] = base64_encode(random_bytes(16));
        }
        
        return $_SESSION['_rb_csrf_token'];
    }

    public static function verifyCSRFToken($token)
    {
        if(!isset($_SESSION['_rb_csrf_token'])) return false;
        if($_SESSION['_rb_csrf_token'] == $token)
        {
            unset($_SESSION['_rb_csrf_token']);
            return true;
        }

        return false;
    }
}