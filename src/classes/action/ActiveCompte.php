<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;

class ActiveCompte extends Action
{

    public function execute(): string
    {
        if (isset($_COOKIE['token'])) {


            $db = ConnectionFactory::makeConnection();
            $sql = ("update user set id =1 where email=?");
            $st = ConnectionFactory::$db->prepare($sql);
            $var = $_GET['email'];
            $st->bindParam(1, $var);
            $st->execute();

            /**    $sql = "update user set id =1 where email=? ";
             * $db = ConnectionFactory::makeConnection();
             * $st=$db->prepare($sql);
             * $st->execute([$var]);
             * $row=$st->fetch(\PDO::FETCH_ASSOC);
             * $st->execute();
             **/

        } else {
            echo "lien expire";
        }

        return "Votre adresse mail est validé !";
    }


}





