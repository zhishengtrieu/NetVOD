<?php
declare(strict_types=1);
namespace netvod\action;
use netvod\auth\Auth;

class AddUserAction extends Action{
    public function execute(): string{
        if($this->http_method == 'POST'){
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
            $genre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
            $res = "Email: $email, Age: $age ans, Genre musical: $genre";
            if (isset($_POST['email']) and isset($_POST['pwd'])){
                if(Auth::register($_POST['email'], $_POST['pwd'])){
                    echo "L'utilisateur a bien été enregistré <br>";
                }else{
                    echo "L'utilisateur n'a pas pu être enregistré <br>";
                }
            }
        }else{
            $res= <<<END
            <form action="?action=add-user" method="POST">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="pwd" placeholder="password">
            <input type="number" name="age" placeholder="Age">
            <input type="text" name="genre" placeholder="Genre Musical">
            <input type="submit" value="Connexion">
            </form>
            END;
        }
        return $res;
    }
}
?>