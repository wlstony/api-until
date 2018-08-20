<?php
namespace app\controllers;

use app\components\Controller;
use Docmk\Api;
use Docmk\utils\DocMaker;

class DocController extends Controller {

    function actionIndex() {
        $api = new Api();
        $dir = dirname(__FILE__);
        $controllers = $api->loadRoutesFromDir($dir, 'app\controllers');

       $doc = '';
       $maker = new DocMaker();
        foreach ($controllers as $controller) {
            $title = $controller->getDescription() . $controller->getSummary();

            if (! $title) {
                continue;
            }

            $doc .= '<h2>' . $title . '</h2>';
            $routes = $controller->getRoutes();
            if (! $routes) {
                continue;
            }
            foreach ($routes as $route) {
                $doc .= $maker->makeRequest($controller, $route);
                $doc .= $maker->makeResponse($controller, $route);
                $doc .= "\n";

            }
            $doc .= "\n";
        }
        
        $parseDown = new \Parsedown();
        $html = $parseDown->text($doc);

        return $html;
    }
}
