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

    $summons = Summons::getFromSession();

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

$app->get('/new-summons', function() 
{
    $summons = new Summons();

    $summons->setData(Summons::getSummons());

    $summons->setToSession();

    header("Location: /");
    exit;

});

//*NECESSITA DE AJUSTES
//momentaneamente usado pra testes
$app->post('/submit-summons', function () {
    echo "publicacao classificada!";

    $summons = new Summons();

    $_POST['pub_id'] = $_SESSION[Summons::SESSION]['pub_id'];

    $summons->setData($_POST);

    session_unset();

    $summons->saveClassification();

    Header("Location: /");
    exit;
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