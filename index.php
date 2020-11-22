<?php
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \IADireito\Page;
use \IADireito\Summons;
use \IADireito\htmlOptions;
use \IADireito\User;

$app = new Slim();

$app->config('debug', true);

require_once("site.php");

$app->run();
?>