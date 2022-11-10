<?php

namespace netvod\action;

use netvod\auth\Auth;
use netvod\db\ConnectionFactory;

class ForgotPassword extends Action
{

    public function execute(): string
    {
        if (isset($_COOKIE['mdpchangement'])) {
            $mdpchg = $_COOKIE['mdpchangement'];
            if ($this->http_method == 'POST') {
                $pwd = $_POST['pwd'];
                $mail = $_GET['email'];
                if (($pwd !== '') && (strlen($pwd) >= 10)) {
                    if (!Auth::emailLibre($mail)) {
                        $db = ConnectionFactory::makeConnection();
                        $sql = ("select role from user where email=?");
                        $st = ConnectionFactory::$db->prepare($sql);
                        $st->bindParam(1, $mail);
                        $st->execute();
                        $row = $st->fetch();
                        $role = ($row['role']);
                        if (!$role == 0) {
                            $db = ConnectionFactory::makeConnection();
                            $sql = ("update user set passwd =? where email=?");
                            $st = ConnectionFactory::$db->prepare($sql);
                            $password = password_hash($pwd, PASSWORD_DEFAULT);
                            $st->bindParam(1, $password);
                            $st->bindParam(2, $mail);
                            $st->execute();
                            $res = "Vous avez changé de Mot de passe ";
                            setcookie('mdpchangement', NULL, -1);
                        } else {
                            $res = "Votre adresse Mail n'a pas été validée";
                        }
                    } else {
                        $res = "Votre adresse mail n'est pas dans notre base de données";
                    }
                } else {
                    $res = "Mettez un vrai Mot de Passe";
                }
            } else {
                $mail = $_GET['email'];
                $res = <<<END
            <form action="?action=$mdpchg&email=$mail
            " method="post">
                <input type="password" name="pwd" placeholder="password">
                <input type="submit" value="Valider">
            </form>
            END;
            }
        }
        return $res;

    }
}