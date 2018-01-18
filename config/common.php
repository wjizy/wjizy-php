<?php

use wjizy\config\CG;
function wjizy_view($wjizy, $view)
{
    require_once APP_PATH.'/src/views/'.$view.'.php';
}

function wjizy_json($array)
{
    header('Content-type: application/json');
    echo json_encode([
        'wjizy_code' =>CG::$wjizy_code,
        'wjizy_msg'  =>CG::$wjizy_msg,
        'result'     =>$array
    ]);
    exit();
}

function wjizy_error_info($code, $msg)
{
    CG::$wjizy_code = $code;
    CG::$wjizy_msg  = $msg;
}

function debug($msg, $dir='')
{

}

function error($msg, $dir='')
{

}
