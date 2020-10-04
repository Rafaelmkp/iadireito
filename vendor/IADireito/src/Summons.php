<?php

namespace IADireito;

use \IADireito\DB\Sql;
use \IADireito\Model;

class Summons extends Model {

    public static function getSummons() {

        $sql = new Sql();

        //query apenas para testes, comando a ser substituido por PROCEDURE
        $results = $sql->select("SELECT pub_numero_processo, pub_conteudo FROM tb_pub 
            WHERE pub_id = 526934655");

        return $results[0];
    }

    public function setSummons() {

        try {
            $this->setData(Summons::getSummons());
        } catch (\Exception $e) {
            echo "não foi possivel retornar uma intimação";
        }
    }

    public function saveSummons() 
    {
        $sql = new Sql();

        //query a desenvolver
        //$sql->query("CALL sp_summons_save(
        //    :ESTRUTURA, :N_CNJ,  )");

        return true;
    }
    

}

?>