<?php
namespace Docmk;


use Docmk\containers\ControllerContainner;
use Docmk\utils\DocVisitor;
use Docmk\handlers\HanderFactory;

class Api
{
    /**
    * 从目录中加载路由
    * 不支持目录递归
    * @param $dir string 目标路径
    */
    function loadRoutesFromDir($dir, $namespace) {
        if (! is_dir($dir)) {
            echo "无法从 {$dir} 中加载路由";
            return;
        }
        $d = dir($dir);
        $readeach = function() use($d) {
            $file = $d->read();

            return $file;
        };
        $routes = [];
        while (!! ($entry = $readeach())) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            $fullPath = $dir . '/' . $entry;

            if (is_file($fullPath) && substr_compare($entry, '.php', -4, 4) === 0) {
                $className = $namespace . '\\' . substr($entry, 0, strlen($entry)-4);
                try{
                    $route = $this->loadRoutesFromClass($className);
                    $routes[] = $route;
                } catch (\Exception $e) {
                    echo '路由加载异常: ' . $e->getMessage();
                    throw $e;
                }
            } else {
                echo "{$fullPath} 非php文件,不能加载route";
            }
        }

        return $routes;
    }

    /**
    * 从controller中加载路由
    * @param $class string controller的类名称
    */
    function loadRoutesFromClass($class) {
        $controller = new ControllerContainner($class);

        DocVisitor::visitDoc($class, function($type, $action, $tag, $desc) use($controller) {
            $handler = HanderFactory::getHandler('controller', $tag, $desc, $controller, $action);
            if ($handler) {
                $handler->handle();
            }
        });

        return $controller;
    }
}