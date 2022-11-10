<?php
declare(strict_types=1);

namespace netvod\action;

use netvod\auth\Auth;
use netvod\audio\lists\Playlist;
use netvod\render\AudioListRenderer;
use netvod\user\User;
use netvod\auth\AccessControlException;

class SigninAction extends Action
{
    public function execute(): string
    {
        if ($this->http_method == 'POST') {
            $res = '';

            if (isset($_POST['email']) and isset($_POST['pwd'])) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                $user = Auth::authenticate($email, $_POST['pwd']);
                if (isset($_SESSION['user'])) {
                    try {
                        Auth::checkAccessLevel(USER::NORMAL_USER);
                        $res = " Bienvenu ! $email";
                    } catch (AccessControlException $e) {
                        $res .= $e->getMessage();
                    }
                } else {
                    $res = "L'authentification a échoué";
                }
            }
            if (isset($_POST['yu'])) {
                $track = uniqid();
                setcookie("kittie", $track,
                    Time() + 60 * 60 * 24 * 365);
                $res = <<<END
            <form action="?action=signin" method="post">
                <input type="email" name="emaeil" placeholder="email">
            </form>
            END;
            } else {
                if (isset($_COOKIE['kittie'])) {
                    $track = $_COOKIE['kittie'];
                    $email = filter_var($_POST['emaeil'], FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                    if (($email !== '')) {
                        $url = "?action=$track&email=$email";
                        $res = "Bienvenu  Voici votre lien $email <br>
                            <a href='$url'>Changer votre mot de passe ici</a>";
                    }else{
                        $res="Entrer un email";
                    }
                }
        }


        } else {

            setcookie('kittie');
            $res = <<<END
            <form action="?action=signin" method="post">
                <input type="email" name="email" placeholder="email">
                <input type="password" name="pwd" placeholder="password">
                <input type="submit" value="Se connecter">
                <input type="submit" name='yu'value="Mot de passe oublié ?">
            </form>
            END;
        }
        return $res;
    }

}


?>