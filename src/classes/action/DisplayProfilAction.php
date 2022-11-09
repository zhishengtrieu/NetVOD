<?php
declare(strict_types=1);

namespace netvod\action;

use netvod\db\ConnectionFactory;

class DisplayProfilAction extends Action
{

    public function execute(): string
    {
        ConnectionFactory::makeConnection();
        $res = "";

        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $email = $user->email;
            if ($this->http_method == 'POST') {
                if (isset($_POST['nom'])) {
                    if ($_POST['nom'] !== "") {
                        $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
                        $sql = ("update user set nom=? where email=?");
                        $st = ConnectionFactory::$db->prepare($sql);
                        $st->bindParam(1, $nom);
                        $st->bindParam(2, $email);
                        $st->execute();
                        $res="Changement Profil effecutée";
                    }
                }
                if (isset($_POST['prenom'])) {
                    if ($_POST['prenom'] !== "") {
                        $ui = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
                        $sqll = ("update user set prenom=? where email=?");
                        $st = ConnectionFactory::$db->prepare($sqll);
                        $st->bindParam(1, $ui);
                        $st->bindParam(2, $email);
                        $st->execute();
                        $res="Changement Profil effecutée";
                    }
                }

            } else {
                $res = <<<END
            <form action="?action=display-profil" method="POST">
            <input type="text" name="nom" placeholder="Nom" value="$user->nom">
            <input type="text" name="prenom" placeholder="Prenom" value="$user->prenom">
            <input type="submit" value="valider">
            </form>
            END;

            }

        }
        return $res;
    }
}