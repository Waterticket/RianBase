<?php

class File {
    static function read($file_name)
    {
        if(is_file($file_name)){
            $handle = fopen($file_name, "r");
            $contents = fread($handle, filesize($file_name));
            fclose($handle);

            return $contents;
        }
        
        else return false;
    }
}