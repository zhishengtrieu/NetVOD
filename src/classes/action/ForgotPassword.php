<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;

class ForgotPassword extends Action
{

    public function execute(): string
    {
        if (isset( $_COOKIE[ 'kittie' ] )) {

            $sora = $_COOKIE['kittie'];
            if ($this->http_method == 'POST') {
                $pwd = $_POST['pwd'];
                $db = ConnectionFactory::makeConnection();
                $sql = ("update user set passwd =? where email=?");
                $st = ConnectionFactory::$db->prepare($sql);
                $var = $_GET['email'];
                $st->bindParam(1, $pwd);
                $st->bindParam(2, $var);
                $st->execute();
                $res = "Vous avez changer de Mot de passe ";
            } else {
                $res = <<<END
            <form action="?action=$sora" method="post">
                <input type="password" name="pwd" placeholder="password">
                <input type="submit" value="Valider">
            </form>
            END;
            }
        }

        return $res;
    }
}