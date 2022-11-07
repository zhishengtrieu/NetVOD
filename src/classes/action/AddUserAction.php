<?php
declare(strict_types=1);

namespace netvod\action;

use netvod\auth\Auth;
use netvod\db\ConnectionFactory;

class AddUserAction extends Action
{
    public function execute(): string
    {
        if ($this->http_method == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $pss = $_POST['pwd'];
            $lolss = $_POST['pwdd'];
            $res = "";
            if ($lolss === $pss) {
                if (isset($_POST['email']) and isset($_POST['pwd']) and isset($_POST['pwdd'])) {
                    if (Auth::register($_POST['email'], $_POST['pwd'])) {
                        echo "L'utilisateur a bien été enregistré <br>";
                        setcookie("token", uniqid(),
                            Time() + 60 * 60 * 24 * 365);
                        $res =" Bienvenu  Voici votre lien $email <br>";

                        }
                    if (Auth::authenticate($_POST['email'], $_POST['pwd'])) {
                        if (isset($_COOKIE['token'])) {
                            if ($_GET['id'] === null) {
                                $db= ConnectionFactory::makeConnection();
                                $sql=("update user set id =1 where email=?");
                                $st=ConnectionFactory::$db->prepare($sql);
                                $var=$_POST['email'];
                                $st->bindParam(1,$var);
                                $st->execute();

                            /**    $sql = "update user set id =1 where email=? ";
                                $db = ConnectionFactory::makeConnection();
                                $st=$db->prepare($sql);
                                $st->execute([$var]);
                                $row=$st->fetch(\PDO::FETCH_ASSOC);
                                $st->execute();
                            **/
                              }
                        }
                    }
                } else {
                    echo "L'utilisateur n'a pas pu être enregistré <br>";
                }
            } else {
                echo "Mot de passe Incorect";
            }

        } else {
            $res = <<<END
            <form action="?action=add-user" method="POST">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="pwd" placeholder="password">
            <input type="password" name="pwdd" placeholder="password">
            <input type="submit" value="Connexion">
            </form>
            END;
        }
        return $res;
    }
}

?>