<?php

require_once("vendor/autoload.php");

use \Slim\Slim;
use \IADireito\Page;
use \IADireito\Summons;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function()
{

    $summons = new Summons();

    $summons->setSummons();

    $page = new Page([
        "header" => false,
        "footer" => false
    ]);
    
    $page->setTpl("formulario", array(
        "summons"=>$summons->getValues()
    ));
    
});

$app->run();
?>