<?php
declare(strict_types=1);

namespace netvod\action;

use netvod\auth\Auth;
use netvod\audio\lists\Playlist;
use netvod\render\AudioListRenderer;
use netvod\user\User;
use netvod\auth\AccesControlException;

class SigninAction extends Action
{
    public function execute(): string
    {
        if ($this->http_method == 'POST') {
            $res = '';
            if (isset($_POST['email']) and isset($_POST['pwd'])) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                if (isset($_SESSION['user'])) {
                        try {
                            Auth::checkAccessLevel(USER::NORMAL_USER);
                            $res = " Bienvenu ! $email";
                        }catch(AccessControlException $e){
                            $res .= $e->getMessage();
                        }
                } else {
                    $res = "L'authentification a échoué";
                }
                

            }
        } else {
            $res = <<<END
            <form action="?action=signin" method="post">
                <input type="email" name="email" placeholder="email">
                <input type="password" name="pwd" placeholder="password">
                <input type="submit" value="Se connecter">
                <button onclick="http://localhost/SAE-Trieu-Rouyer-Los-Gallion/index.php;">Cliquez Ici</button>
            </form>
            END;
        }
        return $res;
    }

}


?>