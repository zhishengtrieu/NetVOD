<?php
declare(strict_types=1);
namespace netvod\auth;
use netvod\user\User;
use netvod\db\ConnectionFactory;
use netvod\audio\lists\Playlist;
use netvod\exception\AccessControlException;
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

    /**
     * Permet de verifier si l'utilisateur a les droits suffisants pour acceder a la page
     */
    public static function checkAccessLevel (int $required): void {
        $userLevel = (int) unserialize($_SESSION['user'])->role;
        if ($userLevel < $required){
            throw new AccessControlException("action non autorisée : droits insuffisants");
        }
    }

    /**
     * methode permettant d'authentifier un utilisateur
     * d'en creer l'objet et de le stocker dans la session
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public static function authenticate(string $email, string $password) : ?User{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return null;
        $res=null;
        ConnectionFactory::makeConnection();
        $req = ConnectionFactory::$db->prepare(
            "SELECT passwd, role FROM user WHERE email ='$email'"
        );
        
        $req->execute();
        $result = $req->fetch();
        if (!self::emailLibre($email)){
            if (password_verify($password, $result[0])){
                $res = new User($email, $password, intval( $result[1]));
                $_SESSION['user'] = serialize($res);
            }
        }
        return $res;
    }
    /**
     * Methode permettant de s'enregistrer dans la base de données
     * @param string $email
     * @param string $password
     * @return bool
     */
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
                        'INSERT INTO user VALUES (0, :email, :password, "", "",0)'
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