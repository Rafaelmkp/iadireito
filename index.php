<?php
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \IADireito\Page;
use \IADireito\Summons;
use \IADireito\htmlOptions;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function()
{
    $summons = new Summons();

    $summons->setSummons();

    $summons->setToSession();

    $estrutura_jud = htmlOptions::getEstruturaFromDB();
    $decisao_tipo = htmlOptions::getTipoDecisaoFromDB();
    $peca_produzir = htmlOptions::getPecaProduzirFromDB();
    $natureza = htmlOptions::getNaturezaFromDB();

    $page = new Page();

    $page->setTpl("formulario", array(
        "summons"=>$summons->getValues(),
        "estrutura_jud"=>$estrutura_jud,
        "decisao_tipo"=>$decisao_tipo,
        "peca_produzir" => $peca_produzir,
        "natureza"=> $natureza
    ));
});

//*NECESSITA DE AJUSTES
//momentaneamente usado pra testes
$app->post('/submit-summons', function () {
    echo "publicacao classificada!";

    $summons = new Summons();
    $summons->setData($_POST);

    //var_dump($summons->saveClassification());


    var_dump($summons);
    //var_dump(Summons::procTest());
    //definir msg erro
});

/*
$app->get('/resultado-inclusao', function ($message){

    //retornar msg erro

    $page = new Page();

    $page->setTpl("resultado_inclusao", array(
        $message
    ));
});
*/
$app->run();
?>