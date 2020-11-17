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

    if(!$_SESSION[Summons::SESSION]) {
        $summons->setData(Summons::getSummons());
        $summons->setToSession();
    } else {
        $summons->setData($_SESSION);
    } git 

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

    var_dump($summons->getpub_id());
    var_dump($summons->getestrutura());
    var_dump($summons->getn_processo());
    var_dump($summons->getnatureza());
    var_dump($summons->getvara());
    var_dump($summons->getestado());
    var_dump($summons->getcidade());
    var_dump($summons->getjuiz());
    var_dump($summons->getrecurso());
    var_dump($summons->gettipo_peca());
    var_dump($summons->getinicio());
    var_dump($summons->getdias_prazo());
    var_dump((bool)$summons->getdias());
    var_dump($summons->getfim());
    var_dump((bool)$summons->getyesno());
    var_dump($summons->getcustas());

    exit;

    //$summons->saveClassification();

    session_unset();
    
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