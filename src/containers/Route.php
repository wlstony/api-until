<?php
namespace Docmk\containers;

use phpDocumentor\Reflection\DocBlockFactory;


class Route
{
    private $_uri;
    private $_method;
    private $_author;
    private $_params;
    private $_middles;
    private $_return;
    private $_throw;
    private $_summary;
    private $_description;
    private $_controller;

    function __construct($class, $action) {
        $reflection = new \ReflectionMethod($class, $action);
        $doc = $reflection->getDocComment();
        if ($doc) {
            $factory  = DocBlockFactory::createInstance();
            $docblock = $factory->create($doc);

            $summary = $docblock->getSummary();
            $description = strval($docblock->getDescription());

            $this->_summary = $summary;
            $this->_description = $description;
        }
    }

    function setUri($uri) {
        $this->_uri = $uri;
    }

    function getUri() {
        return $this->_uri;
    }

    function setMethod($method) {
        $this->_method = strtolower($method);
    }

    function getMethod() {
        return $this->_method;
    }

    function addParams($name, $param) {
        $this->_params[$name] = $param;
    }

    function getParams() {
        return $this->_params;
    }

    function getSummary() {
        return $this->_summary . $this->_description;
    }

}