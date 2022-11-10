<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;

class ForgotPassword extends Action
{

    public function execute(): string
    {
        if (isset($_COOKIE['kittie'])) {
            $sora = $_COOKIE['kittie'];
            if ($this->http_method == 'POST') {
                $pwd=$_POST['pwd'];
                if (($pwd !== '')&&(strlen($pwd) >= 10)) {
                $db = ConnectionFactory::makeConnection();
                $sql = ("update user set passwd =? where email=?");
                $st = ConnectionFactory::$db->prepare($sql);
                $var = $_GET['email'];
                    $password = password_hash($pwd, PASSWORD_DEFAULT);
                $st->bindParam(1, $password);
                $st->bindParam(2, $var);
                $st->execute();
                $res = "Vous avez changé de Mot de passe ";
                setcookie('kittie', NULL, -1);
            }else{
                    $res="Mettez un vrai Mot de Passe";
                } }else {
                $var = $_GET['email'];
                $res = <<<END
            <form action="?action=$sora&email=$var" method="post">
                <input type="password" name="pwd" placeholder="password">
                <input type="submit" value="Valider">
            </form>
            END;
            }
        }
        return $res;

    }
}