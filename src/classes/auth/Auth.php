<?php
declare(strict_types=1);
namespace netvod\auth;
use netvod\user\User;
use netvod\db\ConnectionFactory;
use netvod\audio\lists\Playlist;

//Classe Auth
class Auth{

    //Methode permettant de savoir si un email est disponible
    public static function emailLibre($email) : bool{
        ConnectionFactory::makeConnection();
        $req = ConnectionFactory::$db->prepare(
            "SELECT email FROM user WHERE email ='$email'"
        );
        $req->execute();
        $result = $req->fetch();
        return empty($result);
    }

    //Methode permettant de s'autentifier
    public static function authenticate(string $email, string $password) : ?User{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return null;
        $res=null;
        ConnectionFactory::makeConnection();
        $req = ConnectionFactory::$db->prepare(
            "SELECT passwd FROM user WHERE email ='$email'"
        );
        
        $req->execute();
        $result = $req->fetch();
        if (!self::emailLibre($email)){
            if (password_verify($password, $result[0])){
                $res = new User($email, $password);
                $_SESSION['user'] = serialize($res);
            }
        }
        return $res;
    }

    //Methode permettant de s'enregistrer dans la base de données
    public static function register(string $email, string $password) : bool{
        //On verifie que l'email est valide. Si ce n'est pas le cas, on retourne false
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
            //On verifie que le mot de passe fait au moins 10 caractères. Si ce n'est pas le cas, on retourne false
            if(strlen($password) < 10){
                return false;
            }else{
                //On verifie que l'email est libre. Si ce n'est pas le cas, on retourne false
                if (self::emailLibre($email)) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    //On insere l'utilisateur dans la base de données ainsi que son mot de passe
                    ConnectionFactory::makeConnection();
                    $req = ConnectionFactory::$db->prepare(
                        'INSERT INTO user VALUES (0, :email, :password, "", "")'
                    );
                    $req->execute(array(
                        'email' => $email,
                        'password' => $password
                    ));
                    //On retourne true pour signifier que l'inscription a bien été effectuée
                    return true;
                }else{
                    return false;
                }
            }
        echo "L'enregistrement c'est mal déroulé";
        return false;
    }
}

?>