<?php
namespace Docmk\handlers\controller;

use Docmk\handlers\BaseHandler;
use Docmk\containers\Route;

class RouteHandler extends BaseHandler
{
    function handle() {
        $params = $this->splitParams($this->_document, 2);

        $method = $params[0];//未验证方法是否是允许的方法
        $uri = $params[1];
        
        $route = new Route($this->_controller->getClass(), $this->_action);
        $route->setUri($uri);
        $route->setMethod($method);

        $this->_controller->addRoutes($this->_action, $route);
    }
}