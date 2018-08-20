<?php
namespace Docmk\containers;

use Docmk\containers\Route;
use phpDocumentor\Reflection\DocBlockFactory;


class Controller
{
    private $_class;
    private $_path;
    private $_description;
    private $_summary;

    private $_routes;

    function __construct($controllerClass) {
        $reflection = new \ReflectionClass($controllerClass);
        $doc = $reflection->getDocComment();
        if ($doc) {
            $factory  = DocBlockFactory::createInstance();
            $docblock = $factory->create($doc);

            $summary = $docblock->getSummary();
            $description = strval($docblock->getDescription());

            $this->_summary = $summary;
            $this->_description = $description;
        }
        $this->_class = $controllerClass;
    }

    function setPath($path) {
        $this->_path = $path;
    }
    function getPath() {
        return $this->_path;
    }

    function setDescription($description) {
        $this->_description = $description;
    }
    function getDescription() {
        return $this->_description;
    }

    function setSummary($summary) {
        $this->_summary = $summary;
    }
    function getSummary() {
        return $this->_summary;
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

    function getRoutes() {
        return $this->_routes;
    }

    function getClass() {
        return $this->_class;
    }

}