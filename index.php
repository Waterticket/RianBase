<?php
/***********************
* RianBase
************************/

include "./common/autoload.php";

Router::add('/', function(){
    echo 'Hello, World! XD';
});

Router::add('/csrf', function(){
    echo 'Token: '.\RianBase\Security\CSRF::getCSRFToken().'<br>';
    echo 'verify: '.\RianBase\Security\CSRF::verifyCSRFToken(\RianBase\Security\CSRF::getCSRFToken());
});

Router::add('/foo/%string/%string', function($var1, $var2){
    echo 'var1: '.$var1.'<br>var2: '.$var2;
});

Router::add('/myip', function(){
    echo "Your IP is ".IP::getIP();
});

Router::add('/json', function(){
    Context::setContentType('json');
    echo json_encode(array('name'=>'hello'));
});

Router::add('/db/test', function(){
    $db_result = Database::executeQuery("SELECT * FROM test_table WHERE test_id = ? OR test_id = ?", 1, 2);
    echo '<pre>'.print_r($db_result, true).'</pre>';
});

Router::add('/test/hello', function(){
    $oTestController = new testController();
    $oTestController->hello();
});

Router::add('/complicated/%number', function(){
    $oTestController = new testController();
    $oTestController->complicatedNumber();
});

Router::run('/');
ob_end_flush();