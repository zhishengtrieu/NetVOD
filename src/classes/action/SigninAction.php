<?php
declare(strict_types=1);
namespace netvod\action;
use netvod\auth\Auth;
use netvod\audio\lists\Playlist;
use netvod\user\User;
use netvod\render\AudioListRenderer;

class SigninAction extends Action{
    public function execute(): string{
        if($this->http_method == 'POST'){
            $res='';
            $email=filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            if (isset($_POST['email']) and isset($_POST['pwd'])) {
                $user = Auth::authenticate($_POST['email'], $_POST['pwd']);
                if ($user != null){
                    $res = " Bienvenu ! $email";
                    }
            }
        }else{
            $res = <<<END
            <form action="?action=signin" method="post">
                <input type="text" name="email" placeholder="email">
                <input type="password" name="pwd" placeholder="password">
                <input type="submit" value="Se connecter">
            </form>
            END;
        }
        return $res;
    }

}


?>