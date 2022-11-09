<?php
declare(strict_types=1);
namespace netvod\auth;
use netvod\user\User;
use netvod\db\ConnectionFactory;
use netvod\audio\lists\Playlist;


class Auth{

    public static function emailLibre($email){
        ConnectionFactory::makeConnection();
        $req = ConnectionFactory::$db->prepare(
            "SELECT email FROM user WHERE email ='$email'"
        );
        $req->execute();
        $result = $req->fetch();
        return empty($result);
    }

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
                //$res = new User($email, $password, $result[1]);
                $_SESSION['user'] = serialize($res);                
            }
        }
        return $res;
    }

    public static function register(string $email, string $password) : bool{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        if(strlen($password) < 10){
            return false;
        }else{
            if (self::emailLibre($email)) {
                echo $email;
                echo $password;
                $password = password_hash($password, PASSWORD_DEFAULT);
                ConnectionFactory::makeConnection();
                $req = ConnectionFactory::$db->prepare(
                    'INSERT INTO user VALUES (0, :email, :password, "", "")'
                );
                $req->execute(array(
                    'email' => $email,
                    'password' => $password
                ));
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