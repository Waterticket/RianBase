<?php
include "common/config.php";
session_start();
ob_start();

// $_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
// $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

function _RianBase_Autoload($className){
    // lookup table
    // 자주 호출하는 애들
    $classTable = array(
        'Router' => true,
        'Database' => true,
        'IP' => true,
        'Context' => true,
    );

    // 시스템적으로 사용하는 애들
    $frameworkTable = array(
        'RianBase\Security\CSRF' => true,
        'RianBase\Message\Exception' => true,
    );

    // echo "Class Load: $className<br>";

    if($classTable[$className])
        include 'classes/'.$className.'/'.$className.'.php';

    else if($frameworkTable[$className])
    {
        $include_str = 'frameworks';
        $exp = explode('\\', $className);
        for($i = 1; $i < count($exp); $i++)
            $include_str .= '/'.$exp[$i];

        include $include_str.'.php';
    }

    else if(strpos($className, "Module") === 0)
    {
        $exp = explode('\\', $className);
        $exp = preg_split('/(?=[A-Z])/', $exp[1]);
        include 'modules/'.$exp[0].'/'.$exp[0].'.'.strtolower($exp[1]).'.php';
    }
}

spl_autoload_register('_RianBase_Autoload');

Router::methodNotAllowed(function($path = '', $method = ''){
    echo "405 Method Not Allowed";//<br><br>Path: ".$path;
});

Router::pathNotFound(function($path = ''){
    echo "404 Not Found";//<br><br>Path: ".$path;
});