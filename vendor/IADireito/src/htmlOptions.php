<?php
namespace IADireito;

use \IADireito\DB\Sql;
use \IADireito\Model;

class htmlOptions extends Model {

    public static function getEstruturaFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT est_id, est_descricao FROM processos.estrutura_jud");
    }

    public static function getTipoDecisaoFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT dec_id, dec_descricao FROM processos.decisao_tipo");
    }
    
    public static function getPecaProduzirFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT pec_id, pec_descricao FROM processos.peca_produzir");
    }

    public static function getNaturezaFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT nat_id, nat_descricao FROM processos.natureza_processual");
    }

    public static function nullifyString($string) 
    {
        $retString;

        if($string === '') {
            $retString = NULL;
        } else {
            if (gettype($string) == "array") {
                foreach($string as &$value) {
                    $value = htmlOptions::nullifyString($value);
                }
            }
            $retString = $string;
        }

        return $retString;
    }
}
?>