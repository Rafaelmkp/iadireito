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
    var_dump((int)$summons->getpub_id());
    var_dump((int)$summons->getestrutura());
    var_dump(htmlOptions::nullifyString($summons->getn_processo()));
    var_dump((int)$summons->getnatureza());
    var_dump(htmlOptions::nullifyString($summons->getvara()));
    var_dump(htmlOptions::nullifyString($summons->getestado()));
    var_dump(htmlOptions::nullifyString($summons->getcidade()));
    var_dump(htmlOptions::nullifyString($summons->getjuiz()));
    var_dump((int)$summons->getrecurso());
    var_dump((int)$summons->gettipo_peca());
    var_dump(htmlOptions::nullifyString($summons->getinicio()));
    var_dump((int)htmlOptions::nullifyString($summons->getdias_prazo()));
    var_dump((bool)$summons->getdias());
    var_dump(htmlOptions::nullifyString($summons->getfim()));
    var_dump((bool)$summons->getyesno());
    var_dump((float)htmlOptions::nullifyString($summons->getcustas()));
    var_dump($summons->getuser_id());
    var_dump(htmlOptions::nullifyString($summons->getadvautor()));
    var_dump(htmlOptions::nullifyString($summons->getoabadvautor()));
    var_dump(htmlOptions::nullifyString($summons->getreu()));
    var_dump(htmlOptions::nullifyString($summons->getoabadvreu()));
    exit;

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