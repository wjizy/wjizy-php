<?php
/**
 * Created by PhpStorm.
 * User: 112363
 * Date: 2018/1/18
 * Time: 下午 03:13
 */

namespace wjizy\api\services;


use wjizy\lib\SQL;

class IndexService extends BaseService
{
    public static function insert($uid,$name)
    {
        $table = SQL::table('test', $uid);
        $sql   = "insert into {$table}(`name`) values(:name)";
        $result= SQL::exec('test', $sql, array('name'=>$name));

        return $result;
    }

    public static function update($uid, $id, $name)
    {
        $table = SQL::table('test', $uid);
        $sql   = "update {$table} set `name`=:name where `id`=:id";

        $result= SQL::exec('test', $sql, array(':name'=>$name,':id'=>$id));

        return $result;
    }

    public static function delete($uid, $id)
    {
        $table = SQL::table('test', $uid);
        $sql   = "delete from {$table} where id=:id";
        $result= SQL::exec('test', $sql, array('id'=>$id));
        return $result;
    }

    public static function select($uid, $id)
    {
        $table = SQL::table('test', $uid);
        $sql   = "select * from {$table} where id=:id";
        $result= SQL::query('test', $sql,[':id'=>$id]);
        return $result;
    }

    public static function init()
    {
        $table = SQL::table('id', 0);
        $sql   = "insert into {$table}(`time`) values(:time)";
        $result= SQL::exec('test', $sql, array(':time'=>time()), 1);
        return $result;
    }
}