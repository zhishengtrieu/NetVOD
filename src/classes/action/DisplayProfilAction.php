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
                if (isset($_POST['nom'])&&isset($_POST['prenom'])&&($_POST['pref']!="")) {
                    if (isset($_POST['nom'])) {
                        if ($_POST['nom'] !== "") {
                            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
                            $sql = ("update user set nom=? where email=?");
                            $st = ConnectionFactory::$db->prepare($sql);
                            $st->bindParam(1, $nom);
                            $st->bindParam(2, $email);
                            $st->execute();
                            $res = "Changement Profil effecutée";
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
                            $res = "Changement Profil effecutée";
                        }
                    }
                    if (isset($_POST['pref'])) {
                        if ($_POST['pref'] !== "") {
                            $id = filter_var($_POST['pref'], FILTER_SANITIZE_STRING);

                            $sqlo = ("select id_genre from genre where libelle_genre=?");
                            $st = ConnectionFactory::$db->prepare($sqlo);
                            $st->bindParam(1, $id);
                            $st->execute();
                            $row = $st->fetch();
                            $ids = $row["id_genre"];


                            $sqla = ("update user set id_genre=? where email=?");
                            $st = ConnectionFactory::$db->prepare($sqla);
                            $st->bindParam(1, $ids);
                            $st->bindParam(2, $email);
                            $st->execute();
                            $res = "Changement Profil effecutée";
                        }
                    }
                }else{
                    $res="Veuillez au moins rentrer au moins une information" ;
                }

            } else {
                $res = <<<END
            <form action="?action=display-profil" method="POST">
            <input type="text" name="nom" placeholder="Nom" value="$user->nom">
            <input type="text" name="prenom" placeholder="Prenom" value="$user->prenom">
            <select name='pref'>
                    <option value="">Selectionner un genre préféré</option>
                    <option value="action">Action</option>
                    <option value="thriller">Thriller</option>
                    <option value="anime">Anime</option>
                    <option value="comedie">Comedie</option>
                    <option value="romance">Romance</option>
                    <option value="horreur">Horreur</option>
                </select>
            <input type="submit" value="valider">
            </form>
            END;
            }
        }
else{
    $res="Veuillez-vous connectez !";
            }

        return $res;
    }
}