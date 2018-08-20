<?php
namespace Docmk\handlers\controller;

use Docmk\handlers\BaseHandler;
use Docmk\containers\ParamContainner;

class ParamHandler extends BaseHandler
{
    function handle() {
        $doc = $this->_document;
        $splitedStrings = $this->splitParams($doc, 6);
        $action = $this->_action;

        $route = $this->_controller->getRoute($action);

        $param = new ParamContainner();
        //$开头的为参数名称
        if (strpos($splitedStrings[0], '$') === 0) {
            $param->setName(substr($splitedStrings[0], 1));
        }
        $param->setType($splitedStrings[1]);
        $param->setDescription($splitedStrings[2]);
        $param->setDefault($splitedStrings[3]);
        $param->setRequired($splitedStrings[4]);

        //5以后都为validation, todo
        // $len = count($splitedStrings);
        // for ($i=5; $i <= $len; $i++) { 

        // }
        $action = $this->_action;
        $route = $this->_controller->getRoute($action);
        $route->addParams($param->getName(), $param);
    }
    
}

