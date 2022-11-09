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
                            if (!isset($_COOKIE['token'])) {
                                setcookie("token", uniqid(),
                                    Time() + 60 * 60 * 24 * 365);
                            }
                            $track_user_code = $_COOKIE['token'];
                            $url = "http://localhost/SAE-Trieu-Rouyer-Los-Gallion/index.php?action=$track_user_code&email=$email";
                            $res = " Bienvenu  Voici votre lien $email <br>";
                            echo "<a href='$url'>activer votre compte ici</a>";
                        }
                    } else {
                        echo "L'utilisateur est déja présent dans notre base de donnée merci d'activer votre compte<br>";
                        if (!isset($_COOKIE['token'])) {
                            setcookie("token", uniqid(),
                                Time() + 60 * 60 * 24 * 365);
                        }
                        $track_user_code = $_COOKIE['token'];
                        $url = "http://localhost/SAE-Trieu-Rouyer-Los-Gallion/index.php?action=$track_user_code&email=$email";
                        $res = " Bienvenu  Voici votre lien $email <br>";
                        echo "<a href='$url'>activer votre compte ici </a>";
                    }
                } else {
                    echo "Mot de passe Incorect";
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
            <input type="submit" value="Connexion">
            </form>
            END;

        }
        return $res;
    }
}

