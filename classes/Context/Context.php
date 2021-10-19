<?php

class Context {
    public static $printType = 'html';
    private static $context_value = array();

    public static function set($name, $var)
    {
        self::$context_value[$name] = $var;
    }

    public static function get($name)
    {
        return self::$context_value[$name];
    }

    public static function pop($name)
    {
        unset(self::$context_value[$name]);
    }

    public static function clearValue()
    {
        self::$context_value = [];
    }

    public static function setContentType($type)
    {
        self::$printType = $type;
    }

    public static function echoContentType()
    {
        switch(self::$printType)
        {
            case 'html':
                $mime = 'text/html';
                break;

            case 'json':
                $mime = 'application/json';
                break;

            case 'text':
            default:
                $mime = 'text/plain';
                break;
        }

        header('Content-type: '.$mime);
    }
}