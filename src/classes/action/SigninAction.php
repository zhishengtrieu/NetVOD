<?php
declare(strict_types=1);

namespace netvod\action;

use netvod\auth\Auth;
use netvod\audio\lists\Playlist;
use netvod\db\ConnectionFactory;
use netvod\render\AudioListRenderer;
use netvod\user\User;
use netvod\exception\AccessControlException;

class SigninAction extends Action
{
    public function execute(): string
    {
        if ($this->http_method == 'POST') {
            $res = '';
            //on recupere les donnees du formulaire dans le cas ou on veut se connecter
            if (isset($_POST['email']) and isset($_POST['pwd'])) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                $user = Auth::authenticate($email, $_POST['pwd']);
                if (isset($_SESSION['user'])) {
                    try {
                        Auth::checkAccessLevel(USER::NORMAL_USER);
                        $res = " Bienvenu ! $email";
                    } catch (AccessControlException $e) {
                        $res .= $e->getMessage() . "<br>Il faut d'abord activer votre compte";
                    }
                } else {
                    $res = "L'authentification a échoué";
                }

                //on gere aussi le cas ou le mot de passe a ete oublie
            }
            if (isset($_POST['forgot'])) {
                //on cree un nouveau cookie
                $track = uniqid();
                setcookie("mdpchangement", $track,
                    Time() + 60 * 60 * 24 * 365);
                //on recupere l'email de l'utilisateur pour le formulaire de mot de passe oublie
                $res = <<<END
                        <form action="?action=signin" method="post">
                            <input type="email" name="emaeil" placeholder="email">
                        </form>
                    END;
                //dans le cas ou le cookie est set et que l'email est recupere
            } elseif (isset($_COOKIE['mdpchangement'])) {
                $track = $_COOKIE['mdpchangement'];
                $email = filter_var($_POST['emaeil'], FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                //on verifie que l'email est bien dans la base de donnee

                //on verifie que l'email est valide
                $db = ConnectionFactory::makeConnection();
                $sql = ("select role from user where email=?");
                $st = ConnectionFactory::$db->prepare($sql);
                $st->bindParam(1, $email);
                $st->execute();
                //on verifie que l'email est valide
                $row = $st->fetch();
                $role = ($row['role']);
                if (!$role == 0) {
                    if (($email !== '')) {
                        if (!Auth::emailLibre($email)) {
                            $url = "?action=$track&email=$email";
                            //on donne le formulaire pour le nouveau mdp
                            $res = "Bienvenu  Voici votre lien $email <br>
                        <a href='$url'>Changer votre mot de passe ici</a>";
                        } else {
                            $res = "Mail non valide";
                        }
                    } else {
                        $res = "Aucun Mail";
                    }
                } else {
                    $res = "Veuiller mettre une adresse mail validé";
                }
            }
        } else {
            //on affiche le formulaire de connexion
            setcookie('mdpchangement');
            $res = <<<END
            <h1>Connexion</h1>
            <form action="?action=signin" method="post">
                <input type="email" name="email" placeholder="email"><br>
                <input type="password" name="pwd" placeholder="password"><br>
                <input type="submit" value="Se connecter"><br>
                <input type="submit" name='forgot' value="Mot de passe oublié ?">
            </form>
            <div id="redirection">
                <p>Toujours pas inscrit ? <a href="index.php?action=add-user">Inscrivez-vous !</a></p>
            </div>
            END;
        }
        return $res;
    }

}


?>