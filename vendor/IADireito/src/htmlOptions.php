<?php
namespace IADireito;

use \IADireito\DB\Sql;
use \IADireito\Model;

class htmlOptions extends Model {

    public static function getTipoDecisaoFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT dec_descricao FROM processos.decisao_tipo");
    }
    
    public static function getPecaProduzirFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT pec_descricao FROM processos.peca_produzir");
    }

    public static function getNaturezaFromDB () 
    {        
        $sql = new Sql();

        return $sql->select("SELECT nat_descricao FROM processos.natureza_processual");
    }
}
?>