<?php

namespace IADireito;

use \IADireito\DB\Sql;
use \IADireito\Model;

class Summons extends Model {

    const SESSION = "Summons";

    public static function getSummons() {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM processos.select_pub_nao_classif()"
        );

        //criando chaves independentes dos nomes usados no DB
        $data = [];
        $data["id"] = $results[0]["pub_id"];
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
    

    public function saveClassification() {

        $id = 0;

        //call procedure publicacao
        $this->saveClassifiedSummons($id);

        return $id;

        //call procedure advogado
            //procedure jah salva em adv_x_pub

        //call procedure parte
            //procedure jah salva em parte_x_pub

        
    }

    //futuramente tratar usuario classificador
    public function saveClassifiedSummons(&$idreturn) 
    {
        $sql = new Sql();

        $result = $sql->outputProcedure("CALL processos.salva_pub_class(
            :OLD_ID ,:ESTRUTURA, :N_PROCESSO, :NATUREZA, :VARA, :ESTADO, 
            :CIDADE, :JUIZ, :DECISAO_TIPO, :PECA_PRODUZIR, :INI_PRAZO, :PRAZO, 
            :FIM_PRAZO, :HA_CUSTAS, :VAL_CUSTAS, :USER, :RETURN
            )",
            [
                'OLD_ID' => $this->getid(),
                'ESTRUTURA' => $this->getestrutura(),
                'N_PROCESSO' => $this->getn_processo(),
                'NATUREZA' => $this->getnatureza(),
                'VARA' => $this->getvara(),
                'ESTADO' => $this->getestado(),
                'CIDADE' => $this->getcidade(),
                'JUIZ' => $this->getjuiz(),
                'DECISAO_TIPO' => $this->getrecurso(),
                'PECA_PRODUZIR' => $this->gettipo_peca(),
                'INI_PRAZO' => $this->getinicio(),
                'PRAZO' => $this->getdias_prazo(),
                'FIM_PRAZO' => $this->getfim(),
                'HA_CUSTAS' =>$this->getyesno(),
                'VAL_CUSTAS' => $this->getcustas(),
                'USER' => 1 ,
                'RETURN'=>0
        ]);

        $idreturn = $result[0]['idreturn'];
    }
}
?>