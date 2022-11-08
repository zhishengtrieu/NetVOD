<?php

namespace netvod\action;

use netvod\auth\Auth;
use netvod\db\ConnectionFactory;

class ActiveCompte extends Action
{

    public function execute(): string
    {

        $token = $_COOKIE['token'];
         if ($this->http_method == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $res = "";
                    if (Auth::register($_POST['email'], $_POST['pwd'])) {
                        echo "L'utilisateur a bien été enregistré <br>";




                    }
                if (Auth::authenticate($_POST['email'], $_POST['pwd'])) {
                 if (isset($_COOKIE['token'])) {

                     $db = ConnectionFactory::makeConnection();
                     $sql = ("update user set id =1 where email=?");
                     $st = ConnectionFactory::$db->prepare($sql);
                     $var = $_POST['email'];
                     $st->bindParam(1, $var);
                     $st->execute();

                     /**    $sql = "update user set id =1 where email=? ";
                      * $db = ConnectionFactory::makeConnection();
                      * $st=$db->prepare($sql);
                      * $st->execute([$var]);
                      * $row=$st->fetch(\PDO::FETCH_ASSOC);
                      * $st->execute();
                      **/

                 }
            }
        }else {
            $res = <<<END
            <form action="?action=$token" method="POST">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="pwd" placeholder="password">
            <input type="submit" value="Connexion">
            </form>
            END;

        }
        return $res;
    }


    }


 ?>


