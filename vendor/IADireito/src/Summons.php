<?php

namespace IADireito;

use \IADireito\DB\Sql;
use \IADireito\Model;

class Summons extends Model {

    const SESSION = "Summons";

    public static function getSummons() {

        $sql = new Sql();

        //query apenas para testes, comando a ser substituido por PROCEDURE
        $results = $sql->select("SELECT 
            pub_id, pub_numero_processo, pub_conteudo 
            FROM processos.publicacao_uniritter 
            WHERE pub_id = 526934655"
        );

        //criando chaves independentes dos nomes usados no DB
        $data = [];
        $data["id"] = $results[0]["pub_id"];
        $data["num_proc"] = $results[0]["pub_numero_processo"];
        $data["conteudo"] = $results[0]["pub_conteudo"];

        return $data;
    }

    public function setSummons() 
    {
        try {
            $this->setData(Summons::getSummons());
        } catch (\Exception $e) {
            echo "não foi possivel retornar uma intimação";
        }
    }

    //METODO A DESENVOLVER
    public function saveSummons() 
    {
        $sql = new Sql();

        //query a desenvolver
        //$sql->query("CALL sp_summons_save(
        //    :ESTRUTURA, :N_CNJ,  )");

        return true;
    }

    public function setToSession() 
    {
        $_SESSION[Summons::SESSION] = $this->getValues();
    }

    public static function getFromSession() 
    {
        $summons = new Summons();

        if (isset($_SESSION[Summons::SESSION]) 
            && 
            (int)$_SESSION[Summons::SESSION]['pub_id'] > 0) 
        {
            $summons->get((int)$_SESSION[Summons::SESSION]['pub_id']);
        }
        else 
        {
            $summons = Summons::getSummons();

            $summon->setToSession();
        }

        return $summons;
    }
    

    public static function procTest() {
        $sql = new Sql();

        $return = 0;

        $results = $sql->outputProcedure("CALL processos.salva_pub_class(:CONTEUDO, :ESTRUT, :NUM_CNJ, :NUM_PROC, 
            :NAT_PROC, :VARA, :ESTADO, :COMARCA, :JUIZ, :DEC_TIPO, :PECA_PROD, 
            :INC_PRAZO, :PRAZO, :UTEIS, :FIM_PRAZO, :CUSTAS, :RETURN)",
            [
                ':CONTEUDO'=>"conteudo",
                ':ESTRUT'=> "processual", 
                ':NUM_CNJ'=> 1234, 
                ':NUM_PROC'=> "abc123", 
                ':NAT_PROC'=> "adm", 
                ':VARA'=> "3",
                ':ESTADO'=> "rs", 
                ':COMARCA'=> "noia",
                ':JUIZ'=>"juiz",
                ':DEC_TIPO'=>"decisao",
                ':PECA_PROD'=>"2020-10-10",
                ':INC_PRAZO'=>NULL,
                ':PRAZO'=>10,
                ':UTEIS'=>true,
                ':FIM_PRAZO'=>NULL,
                ':CUSTAS'=>true,
                ':RETURN'=>$return
        ]);

        return $results;
    }
}
?>