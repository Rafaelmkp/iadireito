<?php
namespace IADireito;

use \IADireito\DB\Sql;
use \IADireito\Model;

class htmlOptions extends Model {

    public static function getTipoDecisaoFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT tp_value, tp_desc FROM tipo_decisao");
    }
    
    public static function getPecaProduzirFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT pec_value, pec_desc FROM peca_produzir");
    }

    public static function getNaturezaFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT nat_value, nat_desc FROM natureza");
    }
}
?>