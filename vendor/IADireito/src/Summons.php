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
        $data["pub_id"] = $results[0]["pub_id"];
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

        return $summons;
    }

    public function get(int $pub_id)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT pub_id, pub_conteudo FROM processos.publicacao_uniritter 
            WHERE pub_id = :PUB_ID", 
            array(
                ':PUB_ID'=>$pub_id
        ));

        $data = [];
        $data["pub_id"] = $results[0]["pub_id"];
        $data["conteudo"] = $results[0]["pub_conteudo"];

        $this->setData($data);
    }
    

    public function saveClassification() 
    {
        $idNewPub = 0;

        $errorMsg = 0;

        //call procedure publicacao
        //FUNCTION RECEBE EDEREÇO DA VARIAVEL
        $isSummonsClassified = $this->saveClassifiedSummons($idNewPub);

        if($isSummonsClassified) {

            if($this->getautor()) {
                //call procedure parte -- autor
                $this->saveClassifiedSide($this->getautor(), false, $idNewPub);
            }
            
            if($this->getadvautor()) {
                //call procedure advogado -- autor
                $this->saveClassifiedLawyer(
                    $this->getadvautor(),$this->getoabadvautor(), $idNewPub
                );
            }

            if($this->getreu()) {
                //call procedure parte -- reu
                $this->saveClassifiedSide($this->getreu(), true, $idNewPub);
            }

            if($this->getadvreu()) {
                //call procedure advogado -- reu
                $this->saveClassifiedLawyer(
                    $this->getadvreu(),$this->getoabadvreu(), $idNewPub
                );
            }
        }
    }

    //futuramente tratar usuario classificador
    public function saveClassifiedSummons(&$idreturn) 
    {
        $sql = new Sql();

        $result = [];
        $result = $sql->outputProcedure("CALL processos.salva_pub_class(
            :IPUB_OLD_ID ,:IEST_ID, :IPCLAS_NUM_PROCESSO, :INAT_ID, :IPCLAS_VARA, 
            :IPCLAS_ESTADO, :IPCLAS_COMARCA, :IPCLAS_JUIZ, :IDEC_ID, :IPEC_ID, 
            :IPCLAS_INICIO_PRAZO, :IPCLAS_PRAZO, :IPCLAS_DIAS_UTEIS,
            :IPCLAS_FIM_PRAZO, :IPCLAS_HA_CUSTAS, :IPCLAS_VAL_CUSTAS, 
            :IUSER_ID, :IDRETURN
            )",
            [
                'IPUB_OLD_ID' => $this->getpub_id(),
                'IEST_ID' => $this->getestrutura(),
                'IPCLAS_NUM_PROCESSO' => $this->getn_processo(),
                'INAT_ID' => $this->getnatureza(),
                'IPCLAS_VARA' => $this->getvara(),
                'IPCLAS_ESTADO' => $this->getestado(),
                'IPCLAS_COMARCA' => $this->getcidade(),
                'IPCLAS_JUIZ' => $this->getjuiz(),
                'IDEC_ID' => $this->getrecurso(),
                'IPEC_ID' => $this->gettipo_peca(),
                'IPCLAS_INICIO_PRAZO' => $this->getinicio(),
                'IPCLAS_PRAZO' => $this->getdias_prazo(),
                'IPCLAS_DIAS_UTEIS' => (bool)$this->getdias(),
                'IPCLAS_FIM_PRAZO' => $this->getfim(),
                'IPCLAS_HA_CUSTAS' =>(bool)$this->getyesno(),
                'IPCLAS_VAL_CUSTAS' => (float)$this->getcustas(),
                'IUSER_ID' => 1,
                'IDRETURN'=>0
        ]);
        
        try {
            $idreturn = $result[0]['idreturn'];
            return true;

        } catch (\Exception $e) {
            $errorMsg = $sql->getError();
            print_r($errorMsg);
            return false;
        }
    }

    public function saveClassifiedLawyer($lawyer = [], $oab = [], $pclas_id)
    {
        $organizedAdv = array_combine($oab, $lawyer);

        foreach($organizedAdv as $key => $value) {
            $sql = new Sql();

            $sql->query("CALL processos.salva_advogados(:IADV_NOME, :IADV_OAB, :PCLAS_ID)", [
                ':IADV_NOME' => $key,
                ':IADV_OAB' => $value,
                ':PCLAS_ID' => $pclas_id
            ]);
        }
    }

    public function saveClassifiedSide($sides = [], $is_reu, $pclas_id)
    {
        foreach($sides as $value) {
            $sql = new Sql();

            $sql->query("CALL processos.salva_partes(:IPARTES_NOME, :IS_REU, :PCLAS_ID)", [
                ':IPARTES_NOME' => $value,
                ':IS_REU' => $is_reu,
                ':PCLAS_ID' => $pclas_id
            ]);
        }
    }
}
?>