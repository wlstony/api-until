<?php
namespace Docmk\containers;

use Docmk\containers\Route;

class Controller
{
    private $_doc;
    private $_routes;

    function __construct($controllerClass) {
        $reflection = new \ReflectionClass($controllerClass);
        $doc = $reflection->getDocComment();
    }

    function addRoutes($action, Route $route) {
        if (! isset($this->_routes[$action])) {
            return $this->_routes[$action] = $route;
        }
    }

    function getRoute($action) {
        if (! isset($this->_routes[$action])) {
            return "no route for action {$action}";
        }

        return  $this->_routes[$action];
    }

}