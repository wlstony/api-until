<?php
namespace Docmk\handlers\controller;

use Docmk\handlers\BaseHandler;

class PathHandler extends BaseHandler
{

    public function handle() {
        $params = $this->splitParams($this->_document, 1);

        //暂时只使用0的项
        $this->_controller->setPath($params[0]);

    }
    
}