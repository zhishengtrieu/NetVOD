<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;

class ForgotPassword extends Action
{

    public function execute(): string
    {
        if ($this->http_method == 'POST') {
            $pwd = $_POST['pwd'];
            $db = ConnectionFactory::makeConnection();
            $sql = ("update user set password =? where email=?");
            $st = ConnectionFactory::$db->prepare($sql);
            $var = $_GET['email'];
            $st->bindParam(1, $pwd);
            $st->bindParam(1, $var);
            $st->execute();
            $res = "Vous avez changer de Mot de passe ";
        }
        else {
                $res = <<<END
            <form action="?action=Forgot-password" method="post">
                <input type="password" name="pwd" placeholder="password">
                <input type="submit" value="Valider">
            </form>
            END;
            }

        return $res;
    }
}