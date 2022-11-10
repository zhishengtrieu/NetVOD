<?php
declare(strict_types=1);

namespace netvod\action;

use netvod\auth\Auth;
use netvod\db\ConnectionFactory;

class AddUserAction extends Action
{

    public function execute(): string
    {
        $res = "";
        if ($this->http_method == 'POST') {
            if (isset($_POST['email']) and isset($_POST['pwd']) and isset($_POST['pwdd'])) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $pss = $_POST['pwd'];
                $password = $_POST['pwdd'];
                if ($password === $pss) {
                    if (Auth::emailLibre($email)) {
                        if (Auth::register($email, $pss)) {
                            $track_user_code = uniqid();
                            setcookie("token", $track_user_code,
                                Time() + 60 * 60 * 24 * 365);

                            $url = "?action=$track_user_code&email=$email";
                            $res = "Bienvenu  Voici votre lien $email <br>
                            <a href='$url'>Activer votre compte ici</a>";
                        } else {
                            $res = "Pensez a mettre un mail valide et un mot de passe de plus de 10 caractères";
                        }
                    } else {
                        $db = ConnectionFactory::makeConnection();
                        $sql = ("select role from user where email=?");
                        $st = ConnectionFactory::$db->prepare($sql);
                        $var = $_POST['email'];
                        $st->bindParam(1, $var);
                        $st->execute();
                        $row = $st->fetch();
                        $role = ($row['role']);
                        if ($role == 0) {
                            $track_user_code = uniqid();
                            setcookie("token", $track_user_code,
                                Time() + 60 * 60 * 24 * 365);

                            $url = "?action=$track_user_code&email=$email";
                            $res = "L'utilisateur est déja présent dans notre base de donnée merci d'activer votre compte<br>
                            <a href='$url'>Activer votre compte ici</a>";


                        } else {
                            $res = "Votre compte est déjà activé veuillez vous connecter si vous voulez continuer";

                        }

                    }
                } else {
                    $res = "Les mots de passe sont differents";
                }
            } else {
                echo "L'utilisateur n'a pas pu être enregistré <br>";
            }

        } else {
            $res = <<<END
            <form action="?action=add-user" method="POST">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="pwd" placeholder="password">
            <input type="password" name="pwdd" placeholder="password">
            <input type="submit" value="Inscription">
            </form>
            END;

        }
        return $res;
    }
}

