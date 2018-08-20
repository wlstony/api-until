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
        $doc .= '| 状态码 |  数据格式 | 描述 | demo |';
        $doc .= "\n";
        $doc .= '| :------- | :-------: | :-------: | :------- |';
        
        $returns = $route->getReturn();
        if ($returns) {
            foreach ($returns as $return) {
                $status = $return->getStatus();
                $description = $return->getDescription();
                $datatype = trim($return->getDatatype(), '\\'); //php doc底层json，view关键词会带上\
                $demo = $return->getDemo();
                if ($datatype == 'json') {
                    $demo = $this->oneLinePrettyJson($demo);
                }

                $doc .= "\n| {$status} | {$datatype} | {$description} | {$demo} |";
            }
        }

        $doc .= "\n\n";

        return $doc;
    }

    function oneLinePrettyJson($json) {
        if (! $json && json_decode($json) == false) {
            return $json;
        }

        $json = str_replace("\r\n", '<br>', $json);
        $json = str_replace("\n", '<br>', $json);
        $json = str_replace("\r", '<br>', $json);
        $json = str_replace(' ', '&nbsp;', $json);
        $json = str_replace('"', '&quot;', $json);

        return $json;
    }
}