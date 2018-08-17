<?php
namespace Docmk\handlers;

abstract class BaseHandler
{
    protected $_tagName;
    protected $_document;
    protected $_controller;
    protected $_action;


    /**
    * 每行注释切割为两行
    * @param $tagName string @后面作为tag名称
    * @param $document string tag名称除外的所有内容
    * @param $controller object 正在解析的controller
    */
    function __construct($tagName, $document, $controller, $action) {
        $this->_tagName = $tagName;
        $this->_document = $document;
        $this->_controller = $controller;
        $this->_action = $action;
    }


    /** 字符串截取
    * 将一个字符串,按照截成len段,支持\n\t空格
    * @param $string string 需要截取的字符串 required
    * @param $len int 需要截取的长度 required
    * @return String[]
    */
    function splitParams($string, $len) {
        $params = array_fill(0, $len, '');
        $splitedStr = preg_split('/\s+/', $string);

        foreach ($splitedStr as $i => $value) {
            $params[$i] = $value;
        }

        return $params;
    }

    abstract function handle();
}
