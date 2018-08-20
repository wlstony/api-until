<?php
namespace Docmk\containers;

class ParamContainner
{
    private $_name;
    private $_type;
    private $_description;
    private $_default;
    private $_required;
    
    private $_validation;

    

    function setName($name) {
        $this->_name = $name;
    }

    function getName() {
        return $this->_name;
    }

    function setType($type) {
        $this->_type = $type;
    }
    function getType() {
        return $this->_type;
    }

    function setDescription($description) {
        $this->_description = $description;
    }

    function getDescription() {
        return $this->_description;
    }

    function setDefault($default) {
        $this->_default = $default;
    }
    function getDefault() {
        return $this->_default;
    }

    function setRequired($required) {
        $this->_required = $required != false ? true : false;
    }

    function getRequired() {
        return $this->_required;
    }

    function setValidation($validation) {
        $this->_validation = $validation;
    }


}