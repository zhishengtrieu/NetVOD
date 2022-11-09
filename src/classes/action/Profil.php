<?php
declare(strict_types=1);
namespace netvod\action;
class Profil extends Action{

    public function execute(): string
    {
        $res = "";
        if (isset($_SESSION['user'])){
            $user = unserialize($_SESSION['user']);
            $res .= "<h1>Profil</h1>";
    }

        else {
            $res = <<<END
            <form action="?action=add-user" method="POST">
            <input type="text" name="nom" placeholder="Rick">
            <input type="text" name="prenom" placeholder="Roll">
            <input type="submit" value="valider">
            </form>
            END;

        }
        return $res;
    }
}