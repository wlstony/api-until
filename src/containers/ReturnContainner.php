<?php
namespace Docmk\containers;

class ReturnContainner
{
    private $_status;
    private $_description;
    private $_datatype;
    private $_demo;

    function __construct($status, $description, $datatype, $demo) {

        $this->_status = $status;
        $this->_description = $description;
        $this->_datatype = $datatype;
        $this->_demo = $demo;
    }

    function getStatus() {
        return $this->_status;
    }

    function getDescription() {
        return $this->_description;
    }

    function getDatatype() {
        return $this->_datatype;
    }

    function getDemo() {
        return $this->_demo;
    }
}