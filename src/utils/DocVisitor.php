<?php
namespace Docmk\utils;

use phpDocumentor\Reflection\DocBlockFactory;

class DocVisitor
{
    const TYPE_METHOD = 'method';
    const TYPE_PROPERTY = 'property';
    const TYPE_CLASS = 'class';


    function visitDoc($class, $callable) {
        //class
        $reflection = new \ReflectionClass($class);
        $comment = $reflection->getDocComment();
        if (! $comment) {
            echo "{$class} comment not exist!";
            return false;
        }
        $factory  = DocBlockFactory::createInstance();
        $docblock = $factory->create($comment);

        $summary = $docblock->getSummary();
        $description = $docblock->getDescription();

        $tags = $docblock->getTags();

        //method
        $methods = $reflection->getMethods();
        if ($methods) {
            foreach($methods as $method) {
                //继承的方法不管，只管直接生成的方法
                if ($method->class != $class) {
                    continue;
                }

                $comment = $method->getDocComment();
                if (! $comment) {
                    continue;
                }
                
                $docblock = $factory->create($comment);
                $tags = $docblock->getTags();
                foreach ($tags as $tag) {
                    $callable(self::TYPE_METHOD, $method->getName(), $tag->getName(), strval($tag));
                }
                die;
            }
        }

    }
}
