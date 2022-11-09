<?php

namespace netvod\action;

class AddCommentAction extends Action{

    public function execute(): string{
        $res = "";
        if ($this->http_method == 'POST') {
            if (isset($_POST['commentaire']) and isset($_POST['note'])) {
                $commentaire = filter_var($_POST['commentaire'], FILTER_SANITIZE_STRING);
                $note = $_POST['note'];
                if (isset($_SESSION['user'])) {
                    $user = unserialize($_SESSION['user']);
                    $id = $_POST['id'];
                    $email = $user->email;
                    $req = ConnectionFactory::$db->prepare("select COUNT(*) from commentaire where email= $email and id_serie = $id");
                    $req->execute();
                    $result = $req->fetch();
                    if ($result[0] == 0) {
                        $req = ConnectionFactory::$db->prepare("insert into commentaire (email, commentaire, note) values ($email, $commentaire, $note)");
                        $req->execute();
                        $res = "Commentaire ajoute<br>";
                    }else{
                        $res = "Vous avez deja commente <br>";
                    }
                    $_SESSION['user'] = serialize($user);
                }
            } else {
                $res = <<<END
                <form action="?action=add-comment" method="POST">
                    <input type="string" name="commentaire" placeholder="comment">
                    <select name="note">
                        <option value="1">1 etoile</option>
                        <option value="1">1.5 etoile</option>
                        <option value="2">2 etoiles</option>
                        <option value="1">2.5 etoiles</option>
                        <option value="3">3 etoiles</option>
                        <option value="1">3.5 etoiles</option>
                        <option value="4">4 etoiles</option>
                        <option value="1">4.5 etoiles</option>
                        <option value="5">5 etoiles</option>
                        <option value="5">RickRoll etoiles</option>
                    </select>
                    <input type="submit" value="Enregistrer le commentaire">
                </form>
            END;
            }
        }
        return $res;
    }
}