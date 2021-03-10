<?php

namespace IADireito;

use \IADireito\DB\Sql;
use \IADireito\Model;

class User extends Model {

    const SESSION = "User";

    const ERROR = 'UserError';

    //ainda nao há certeza da necessidade
    const ERROR_REGISTER = 'UserErrorRegister';

    public static function getFromSession()
    {
        $user = new User();

        if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['user_id'] > 0)
        {
            $user->setData($_SESSION[User::SESSION]);
        } 

        return $user;
    }

    public function setToSession() 
    {
        $_SESSION[User::SESSION] = $this->getValues();
    }

    //testa se usuario ja esta logado
    public static function checkIfLogged()
    {
        if(
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
        ) {
            //Usuario nao logado
            //enviar para pagina de login
            header("Location: /login");
            exit;
        }
    }


    public static function login($login, $password) 
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM processos.usuario 
        WHERE  user_login = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        if(count($results) === 0)
        {
            throw new \Exception("Invalid user or password.");
        }

        $data = $results[0];

        //ciente da fragilidade de armazenamento direto de string
        //aplicacao lida com dados publicos e nao exige alto grau de segurança
        if ($password === $data["user_password"])
        {
            $user = new User();
            $user->setData($data);
            $user->setToSession();

            return $user;
        } 
        else 
        {
            throw new \Exception("Invalid user or password.");
        }
    } 

    public static function logout()
    {
        if($_SESSION){
            session_unset();
        }
    }

    public static function setError($msg)
    {
        $_SESSION[User::ERROR] = $msg;
    }

    public static function getError()
    {
       User::clearError();

          $msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : "";

       return $msg;
    }

    public static function clearError()
    {
        $_SESSION[User::ERROR] = NULL;
    }

    public function getPasswordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, [
            'cost'=>12
        ]);
    }
}

?>