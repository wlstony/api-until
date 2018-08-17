<?php
namespace Docmk\containers;


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

    function setUri($uri) {
        $this->_uri = $uri;
    }

    function setMethod($method) {
        $this->_method = strtolower($method);
    }

    function addParams($name, $param) {
        $this->_params[$name] = $param;
    }

}