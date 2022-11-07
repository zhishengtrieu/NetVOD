<?php
declare(strict_types=1);
namespace netvod\action;
use netvod\auth\Auth;

class AddUserAction extends Action{
    public function execute(): string{
        if($this->http_method == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $res = "";
            if (isset($_POST['email']) and isset($_POST['pwd'])){
                if(Auth::register($_POST['email'], $_POST['pwd'])){
                    echo "L'utilisateur a bien été enregistré <br>";
                    $res = "Email: $email";
                }else{
                    echo "L'utilisateur n'a pas pu être enregistré <br>";
                }
            }
        }else{
            $res= <<<END
            <form action="?action=add-user" method="POST">
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