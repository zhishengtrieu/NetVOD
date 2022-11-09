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
                $lolss = $_POST['pwdd'];
                if ($lolss === $pss) {
                    if (Auth::emailLibre($email)) {
                        if (Auth::register($email, $pss)) {
                            echo "L'utilisateur a bien été enregistré <br>";
                        } else {
                            echo "Pensez a mettre un mail valide et un mot de passe de plus de 10 caractères";
                        }

                        $track_user_code = uniqid();
                        if (!isset($_COOKIE['token'])) {
                            setcookie("token", $track_user_code,
                                Time() + 60 * 60 * 24 * 365);
                        }
                        $url = "?action=$track_user_code&email=$email";
                        $res == "Bienvenu  Voici votre lien $email <br>
                            <a href='$url'>activer votre compte ici</a>";
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
                            echo "L'utilisateur est déja présent dans notre base de donnée merci d'activer votre compte<br>";

                            $track_user_code = uniqid();
                            setcookie("token", $track_user_code,
                                Time() + 60 * 60 * 24 * 365);

                            $url = "?action=$track_user_code&email=$email";
                            $res = "Bienvenu  Voici votre lien $email <br>
                            <a href='$url'>activer votre compte ici</a>";


                        } else {
                            echo "Votre compte est déjà activer veuillez vous-connectez si vous voulez continuer";
                            echo "<a href=https://www.youtube.com/watch?v=zWaymcVmJ-A>Aseje</a>";
                        }

                    }
                } else {
                    echo "Les mots de passe differents";
                }
            } else {
                echo "L'utilisateur n'a pas pu être enregistré <br>";
            }

        }
    else {
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

