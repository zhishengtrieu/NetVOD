<?php

namespace netvod\action;

class AddCommentAction extends Action
{

    public function execute(): string
    {
        $res = "";
        if ($this->http_method == 'POST') {
            if (isset($_POST['commentaire']) and isset($_POST['note'])) {
                $commentaire = filter_var($_POST['commentaire'], FILTER_SANITIZE_STRING);
                $note = $_POST['note'];
                if (isset($_SESSION['user'])) {
                    $user = unserialize($_SESSION['user']);
                    if ($user->role != USER::NO_USER) {
                        $id = $_POST['id'];
                        $email = $user->email;
                        $req = ConnectionFactory::$db->prepare("select COUNT(*) from commentaire where email= $email and id_serie = $id");
                        $req->execute();
                        $result = $req->fetch();
                        if ($result[0] == 0) {
                            $req = ConnectionFactory::$db->prepare("insert into commentaire (email, commentaire, note) values ($email, $commentaire, $note)");
                            $req->execute();
                            $res = "Commentaire ajoute<br>";
                        } else {
                            $res = "Vous avez deja commente <br>";
                        }
                        $_SESSION['user'] = serialize($user);
                    }
                } else {
                    $res .= 'Il faut se connecter avant d ajouter un commentaire';
                }
            }
        }
        return $res;
    }
}