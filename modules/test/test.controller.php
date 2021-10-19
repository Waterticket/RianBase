<?php

class testController extends testClass {
    public function hello()
    {
        // Shell::executeShell('/volume1/WebServer/rianbase/test.sh');
        // echo "<pre>";
        // print_r(Shell::$_last_exec_out);

        Template::set('name', 'Nene!');
        Template::set('img_src', 'https://taja.hoto.dev/87032663_p0_master1200.jpg');
        Template::set('img_alt','nene!');
        Template::set('img_style', 'height: 400px;');
        echo Template::compileFile('modules/test/skins/test.html');
    }

    public function complicatedNumber()
    {
        $db_result = Database::executeQuery("SELECT * FROM test_table WHERE test_id = 1");

        Template::set('name', $db_result->data->name);
        Template::set('img_src', 'https://taja.hoto.dev/87032663_p0_master1200.jpg');
        Template::set('img_alt','nene!');
        Template::set('img_style', 'height: 400px;');
        echo Template::compileFile('modules/test/skins/test.html');
    }
}