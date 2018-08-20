<?php
namespace Docmk\handlers\controller;

use Docmk\handlers\BaseHandler;
use Docmk\containers\ReturnContainner;

class ReturnHandler extends BaseHandler
{
    function handle() {
        $params = $this->splitParams($this->_document, 4);

        $status = 200;
        $type = '';
        $description = '';
        $demo = '';
        if (is_int($params[0]) && intval($params[0]) == $params[0]) {
            $status =  array_shift($params);//默认为200，如果设置了已设置的为准
            $type = array_shift($params);
            $description = array_shift($params);
        } else {
            $type = array_shift($params); //省略了状态码, 第一个参数为type
            $description = array_shift($params);
        }

        $demo = implode('', $params);//剩下的属于demo
        if (strtolower($type) == '\\json' && json_decode($demo) != false) {
            $demo = json_encode(json_decode($demo, true), JSON_PRETTY_PRINT); //pretty json
        }


        $action = $this->_action;
        $route = $this->_controller->getRoute($action);

        $return = new ReturnContainner($status, $description, $type, $demo);
        $route->addReturn($return);
    }
}