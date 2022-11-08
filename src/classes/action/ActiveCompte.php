<?php

namespace netvod\action;

use netvod\auth\Auth;
use netvod\db\ConnectionFactory;

class ActiveCompte extends Action
{

    public function execute(): string
    {
        if (Auth::authenticate($_POST['email'], $_POST['pwd'])) {
            if (isset($_COOKIE['token'])) {

                $db = ConnectionFactory::makeConnection();
                $sql = ("update user set id =1 where email=?");
                $st = ConnectionFactory::$db->prepare($sql);
                $var = $_POST['email'];
                $st->bindParam(1, $var);
                $st->execute();


            }
        }
        return "bonjour";
    }
}


