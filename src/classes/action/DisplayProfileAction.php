<?php
/**
 * 7. Page d’accueil d’un utilisateur : afficher ses séries préférées
* La page d’accueil d’un utilisateur affiche la liste des séries qu’il a ajouté dans ses préférences.
* La liste est cliquable : on peut afficher le détail d’une série à partir de cette liste.
* La page d’accueil est affichée automatiquement après le login, ou par click sur un bouton
* « retour à l’accueil » depuis toutes les pages.
*/
declare(strict_types=1);
namespace netvod\action;
use netvod\render\Renderer;
use netvod\render\SerieRenderer;
use netvod\user\User;
use netvod\exception\AccessControlException;
use netvod\video\serie\Serie;

class DisplayProfileAction{
    public function execute(): string{
        $res = "";
        if($this->http_method == 'POST'){
            if (isset($_SESSION['user'])){
                $user = unserialize($_SESSION['user']);
                foreach($user->VideosPreferees as $serie){
                    $render = new SerieRenderer($serie);
                    $res .= $render->render(Renderer::COMPACT);
                }
            }
        }
        return $res;
    }
}