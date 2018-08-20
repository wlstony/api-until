# api-docs-maker
基于注释,实现自动生成api，依赖于phpdoc/phpDocumentor,erusev/parsedown，可使用composer安装

基于doc注释，自动生成文档
一、添加controller注释(注释写在类名或方法名前)
1.controller类名注释
/**
 * api相关操作
 * @o-path /api
*/

2.controller action注释
/**
 * 获取api列表
 * @o-route GET /
 * @param  $pageSize int 每页条数 20 false min:10 max:20
 * @param $page int  当前页号 1
 * @param $category int  一级分类id
 * @param $sub_category int  二级分类id
 * @return json 测试json数据 {
                    "status": 101,
                        "data": {
                            "result": true,
                            "id_trade": 123123,
                           "id_user": 19233
                    }
                }
*/

二、代码修改
1.添加一个html文件

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>享换机文档系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/2.10.0/github-markdown.css" rel="stylesheet"></link>


<script type="text/javascript" src="/dist/js/jquery-1.9.1.min.js"></script>
<script src="/dist/js/jquery-ui.js "></script>
<script src="/dist/js/jquery-ui.custom.js "></script>
<script src="/dist/js/jquery.tocify.min.js"></script>
<script src="/dist/js/prettify.js"></script>
<script src="/dist/js/bootstrap.js"></script>

<link rel="stylesheet" type="text/css" href="/dist/css/bootstrap-2.3.1.css" />
<link rel="stylesheet" type="text/css" href="/dist/css/jquery.tocify.css" />
<link rel="stylesheet" type="text/css" href="/dist/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="/dist/css/prettify.css" />

<style>
body {
    padding-top: 20px;
}
p {
    font-size: 16px;
}
.headerDoc {
    color: #005580;
}
@media (max-width: 767px) {
    #toc {
        position: relative;
        width: 100%;
        margin: 0px 0px 20px 0px;
    }
}
</style>
</head>
<body>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div id="toc">
            </div>
        </div>

        <div class="span9">
            <div id="doc" class="markdown-body">
            </div>
        </div>
    </div> <!--/.row-fluid-->
</div><!--/.fluid-container-->
<script>
    $(function() {
        $.ajax({
            cache: false,
            type: "GET",
            url: "/doc/index",
            data: {
                // _csrf: "<?=\Yii::$app->request->getCsrfToken(); ?>"
            },
            success: function(res) {
                $("#doc").html(res);

                var toc = $("#toc").tocify({
                    selectors: "h2,h3,h4,h5"
                }).data("toc-tocify");

                prettyPrint();
                $(".optionName").popover({ trigger: "hover" });
            },
            error: function(request) {
            },
        });
    });
</script>

  </body>
</html>

2.添加一个controller,提供生成文档的action
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

