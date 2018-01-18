<?php
/**
 * Created by PhpStorm.
 * User: 112363
 * Date: 2018/1/18
 * Time: 下午 03:14
 */
namespace wjizy\lib;
use wjizy\config\CG;
use PDO;
use Exception;
define('DB_TIME_OUT',10);
define('DB_ENCODE', '\'utf8mb4\'');
class SQL
{
    public static function query($tag, $sql, $param = array())
    {
        $db = self::get_pdo($tag);
        if ($param == null) $param = [];

        if (($sth = $db->prepare($sql)) === FALSE)
            throw new Exception('Can not prepare statement.');

        if ($sth->execute($param) === FALSE)
            throw new Exception(var_export($sth->errorInfo(), true));

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function exec($tag, $sql, $param = array(), $is_last_id=0)
    {
        $db = self::get_pdo($tag);
        if ($param == null) $param = [];

        if (($sth = $db->prepare($sql)) === FALSE)
            throw new Exception('Can not prepare statement.');

        if ($sth->execute($param) === FALSE)
            throw new Exception(var_export($sth->errorInfo(), true));

        if($is_last_id){
            return $db->lastInsertId();
        }
        return $sth->rowCount();
    }
    private static function get_pdo($tag)
    {
        try{
            list($host, $dbname, $port, $user, $pass) = self::connect_config($tag);
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $user, $pass, [PDO::ATTR_TIMEOUT => MYSQL_TIME_OUT]);
            $pdo->exec('set names ' . DB_ENCODE);
            return $pdo;

        }catch (\PDOException $e){
            error('mysql server error:'.$e->getMessage());
            return false;
        }
    }

    private static function connect_config($tag)
    {
        $config      = CG::$tableConfig[$tag];
        $host_char   = substr($config[1], 0, 1);
        $host_config = CG::$server[$host_char];
        $dbname      = CG::$databases[$tag];

        return array($host_config['host'], $dbname, $host_config['port'], $host_config['user'], $host_config['password']);
    }

    public static function table($tag, $id)
    {
        if(!$id){
            return $tag.'_0';
        }
        $config      = CG::$tableConfig[$tag];
        $num = strlen($config[1]);
        return $tag.'_'.self::hash_id($id, $num);
    }

    private static function hash_id($id, $num)
    {
        $md5      = md5($id);
        $two_char = substr($md5, -2);
        $dec      = hexdec($two_char);
        $suffix_id= $dec%$num;
        return $suffix_id;
    }
}

