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
use netvod\render\EpisodeRenderer;
use netvod\user\User;
use netvod\exception\AccessControlException;
use netvod\video\serie\Serie;

class DisplayHomeAction{
    public function execute(): string{
        $res = "";
        if (isset($_SESSION['user'])){
            $user = unserialize($_SESSION['user']);
            $res .= "
            <p>Vous êtes connecté en tant que $user->email.</p>
            <h1>Ma liste de séries préférées</h1>";
            foreach($user->VideosPreferees as $serie){
                $render = new SerieRenderer($serie);
                $res .= $render->render(Renderer::COMPACT);
            }
            $res .= "<h1>Ma liste de séries en cours</h1>";
            foreach($user->VideosEnCours as $serie_id => $episode){
                $serie = Serie::find($serie_id);
                $res .= "<p>$serie->titre - Episode en cours : $episode->numero</p>";
                $render = new EpisodeRenderer($episode);
                $res .= $render->render(Renderer::COMPACT);
            }
            $res .= "<h1>Ma liste de séries terminées</h1>";
            foreach ($user->VideosVisionnees as $serie){
                $render = new SerieRenderer($serie);
                $res .= $render->render(Renderer::COMPACT);
            }
        }else{
            $res = "Vous devez vous connecter pour accéder à votre profil";
        }
        
        return $res;
    }
}