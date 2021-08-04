<?php
namespace RianBase\Message;

class Exception {
    function __construct($error, $message)
    {
        if(RIANBASE_EXCEPTION_OB_FLUSH) ob_get_clean();
        if($error == EXCEPTION_LEVEL_ERROR) echo "ERROR: ";
        echo $message;
        ob_end_flush();
        die();
    }
}