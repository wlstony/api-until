<?php
namespace Docmk\utils;

use phpDocumentor\Reflection\DocBlockFactory;

class DocMaker
{

    function makeRequest($controller, $route) {
        $summary = $route->getSummary();
        $doc = "\n<h3>{$summary}</h3>\n";

        $doc .= '<strong>URL:</strong> ' . strtoupper($route->getMethod()) . ' ' . $route->getUri();
        $doc .= '<hr />';
        $doc .= "\n\n** 请求: ** \n\n";
        $doc .= '| 名称 | 类型 | 描述 | 默认值 | 是否必填 |';
        $doc .= "\n";
        $doc .= '| :------- | :-------: | :-------: | :-------: | :-------: | -------: |';
        $params = $route->getParams();
        if ($params) {
            foreach ($params as $param) {
                $name = $param->getName();
                $type = $param->getType();
                $description = $param->getDescription();
                $default = $param->getDefault();
                $required = $param->getRequired() ? 'required' : '';

                $doc .= "\n| {$name} | {$type} | {$description} | {$default} | {$required} |";
            }
        }
        $doc .= "\n\n";

        return $doc;
    }


    function makeResponse($controller, $route) {
        $doc = "\n\n** 响应: ** \n\n";
        $doc .= '| 状态码 |  数据格式 | 数据demo | 描述 |';
        $doc .= "\n";
        $doc .= '| :------- | :-------: | :-------: | -------: |';
        
        error_log('route: ' . print_r($route, true));

        $doc .= "\n\n";

        return $doc;
    }
}