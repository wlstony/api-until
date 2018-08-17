<?php
namespace Docmk\handlers;

class HanderFactory
{
    const NAMESPACE_HANDLER_CONTROLLER = 'Docmk\handlers\controller\\';

    /** 
    * @property array 需要修正的tag
    */
    private static $_fix_tag = [
        'o-' => ''
    ];

    static function getHandler($type, $tagName, $desc, $controller, $action) {
        foreach (static::$_fix_tag as $k => $v) {
            $tagName = str_replace($k, $v, $tagName);
        }
        $instance = '';
        switch ($type) {
            case 'controller':
                $class = static::NAMESPACE_HANDLER_CONTROLLER . ucfirst($tagName) . 'Handler';
                if (class_exists($class)) {
                    $reflection = new \ReflectionClass($class);
                    $instance = $reflection->newInstance($tagName, $desc, $controller, $action);
                }
                break;
            
            default:
                # code...
                break;
        }

        return $instance;
    }
}