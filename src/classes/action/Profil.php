<?php
declare(strict_types=1);

namespace netvod\action;

use netvod\db\ConnectionFactory;

class Profil extends Action
{

    public function execute(): string
    {
        ConnectionFactory::makeConnection();
        $res = "";

        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user'])->email;
            var_dump($user);

            if ($this->http_method == 'POST') {
                if (isset($_POST['nom'])) {
                    if ($_POST['nom'] !== "") {
                        $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
                        $sql = ("update user set nom=? where email=?");
                        $st = ConnectionFactory::$db->prepare($sql);
                        $st->bindParam(1, $nom);
                        $st->bindParam(2, $user);
                        $st->execute();
                    }
                }
                if (isset($_POST['prenom'])) {
                    if ($_POST['prenom'] !== "") {
                        $ui = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
                        $sqll = ("update user set prenom=? where email=?");
                        $st = ConnectionFactory::$db->prepare($sqll);
                        $st->bindParam(1, $ui);
                        $st->bindParam(2, $user);
                        $st->execute();
                    }
                }
            } else {
                $res = <<<END
            <form action="?action=profil" method="POST">
            <input type="text" name="nom" placeholder="Rick">
            <input type="text" name="prenom" placeholder="Roll">
            <input type="submit" value="valider">
            </form>
            END;

            }

        }
        return $res;
    }
}