<?php

class Template {
    private static $template_value = array();

    public static function set($name, $var)
    {
        self::$template_value[$name] = $var;
    }

    public static function pop($name)
    {
        unset(self::$template_value[$name]);
    }

    public static function clearValue()
    {
        self::$template_value = [];
    }

    private static function _compile($text)
    {
        $output = preg_replace_callback(
            '/{{\$(.*?)}}/s',
            function ($matches) {
                return self::$template_value[$matches[1]] ?? '';
            },
            $text
        );

        return $output;
    }

    public static function compileFile($file_name, $args = null)
    {
        if($args != null)
        {
            foreach($args as $arg_key => $arg_value)
            {
                self::$template_value[$arg_key] = $arg_value;
            }
        }

        $file_text = File::read($file_name);
        $output = self::_compile($file_text);

        self::clearValue();
        return $output;
    }

    public static function compileText($text, $args = null)
    {
        if($args != null)
        {
            foreach($args as $arg_key => $arg_value)
            {
                self::$template_value[$arg_key] = $arg_value;
            }
        }

        $output = self::_compile($text);

        self::clearValue();
        return $output;
    }
}