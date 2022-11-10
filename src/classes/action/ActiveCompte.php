<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;

class ActiveCompte extends Action
{

    public function execute(): string
    {
        if (isset($_COOKIE['token'])) {


            $db = ConnectionFactory::makeConnection();
            $sql = ("update user set role =1 where email=?");
            $st = ConnectionFactory::$db->prepare($sql);
            $var = $_GET['email'];
            $st->bindParam(1, $var);
            $st->execute();

        } else {
            echo "Lien expire";
        }

        return "Votre adresse mail est validé !";
    }


}





