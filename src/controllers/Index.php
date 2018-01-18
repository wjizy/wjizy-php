<?php
/**
 * Created by PhpStorm.
 * User: 112363
 * Date: 2018/1/17
 * Time: 下午 05:02
 */

namespace wjizy\api\controllers;

use wjizy\api\services\IndexService;

class Index
{
    public function insert($param)
    {
        return IndexService::insert($param['uid'], $param['name']);
    }

    public function update($param)
    {
        return IndexService::update($param['uid'], $param['id'], $param['name']);
    }

    public function delete($param)
    {
        return IndexService::delete($param['uid'],$param['id']);
    }

    public function select($param)
    {
        return IndexService::select($param['uid'], $param['id']);
    }

    public function init()
    {
        return IndexService::init();
    }
}