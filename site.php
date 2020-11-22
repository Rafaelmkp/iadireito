<?php
use \Slim\Slim;
use \IADireito\Page;
use \IADireito\Summons;
use \IADireito\htmlOptions;
use \IADireito\User;

$app->get('/', function()
{
    //FALTA AJUSTE
    User::checkIfLogged();

    $summons = Summons::getFromSession();

    $user = User::getFromSession();

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
    unset($_SESSION[Summons::SESSION]);

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
    $user = User::getFromSession();

    $_POST['pub_id'] = $_SESSION[Summons::SESSION]['pub_id'];
    $_POST['user_id'] = $_SESSION[User::SESSION]['user_id'];

    $summons->setData($_POST);

    //APENAS TESTE
    // var_dump($summons->getpub_id());
    // var_dump($summons->getestrutura());
    // var_dump($summons->getn_processo());
    // var_dump($summons->getnatureza());
    // var_dump($summons->getvara());
    // var_dump($summons->getestado());
    // var_dump($summons->getcidade());
    // var_dump($summons->getjuiz());
    // var_dump($summons->getrecurso());
    // var_dump($summons->gettipo_peca());
    // var_dump($summons->getinicio());
    // var_dump($summons->getdias_prazo());
    // var_dump((bool)$summons->getdias());
    // var_dump($summons->getfim());
    // var_dump((bool)$summons->getyesno());
    // var_dump((float)$summons->getcustas());
    // var_dump($summons->getuser_id());
    // var_dump($summons->getadvautor());
    // var_dump($summons->getoabadvautor());
    // var_dump($summons->getreu());
    // var_dump($summons->getoabadvreu());
    // exit;

    $summons->saveClassification();

    unset($_SESSION[Summons::SESSION]);
    
    Header("Location: /");
    exit;
});

$app->get("/login", function() {

    //verificacao especifica para a pagian de login
    //se usuario logado, nao deve ter acesso a funcao login
    if(isset($_SESSION[User::SESSION])) {
        header("Location: /");
        exit;
    }

	$page = new Page();

	$page->setTpl("login", array(
		'error'=>User::getError()
	));
});

$app->post("/login", function() {
    try {
		$user = User::login($_POST['username'],$_POST['password']);

	} catch(Exception $e) {
		User::setError($e->getMessage());
    }

	header("Location: /");
	exit;
});

$app->get('/logout', function()
{
	User::logout();

	header("Location: /login");
	exit;
});

?>