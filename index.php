<?php

require_once("vendor/autoload.php");

use \Slim\Slim;
use \IADireito\Page;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function()
{

    $page = new Page([
        "header" => false,
        "footer" => false
    ]);
    
    $page->setTpl("formulario");
    
});

$app->run();
?>