<?php
namespace wjizy\config;
define('ENV','dev');

class Config
{
    public static $wjizy_code = 0;
    public static $wjizy_msg  = '';

    public static $server  = array(
        'a'=>array('host'=>'127.0.0.1','user'=>'root','password'=>'root','port'=>3306),
        'b'=>array('host'=>'127.0.0.1','user'=>'root','password'=>'root','port'=>3306),
    );

    public static $databases      = array(
        'test'=>'default',
        'id'  =>'default'
    );
    public static $tableConfig    = array(
        'test'=>array('id','aaaaaaaa'),
        'id'  =>array('id','a')
    );
}

class CG extends Config{}
