<?php
namespace Docmk\containers;

class Param
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

    function setDescription($description) {
        $this->_description = $description;
    }

    function setDefault($default) {
        $this->_default = $default;
    }

    function setRequired($required) {
        $this->_required = $required != false ? true : false;
    }

    function setValidation($validation) {
        $this->_validation = $validation;
    }


}