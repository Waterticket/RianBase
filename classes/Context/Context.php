<?php

class Context {
    public static $printType = 'html';

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