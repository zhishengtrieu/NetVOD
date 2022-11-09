<?php
declare(strict_types=1);
namespace netvod\dispatch;
use netvod\action\ActiveCompte;
use netvod\action\DisplayEpisodeAction;
use netvod\action\FiltrerCatalogueAction;
use netvod\action\RechercherCatalogueAction;
use netvod\render\Header;
use netvod\action\DisplayListeEpisodesAction;
use netvod\action\DisplayCatalogueAction;
use netvod\action\SigninAction;
use netvod\action\AddUserAction;
use netvod\action\DisplayHomeAction;
use netvod\action\SetFavorisAction;
use netvod\action\AddCommentAction;
use netvod\action\DisplayProfilAction;
class Dispatcher{
    public function run(): void{
        Header::render();
        
        $track= isset($_COOKIE['token']) ? $_COOKIE['token'] : "token";
        
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        $res = "";
        switch($action){
            case "add-user":
                $res = (new AddUserAction())->execute();
                break;
            case "signin" :
                $res = (new SigninAction())->execute();
                break;
            case "afficherCatalogue" :
                $res = (new DisplayCatalogueAction())->execute();
                break;
            case "display-episode":
                $res = (new DisplayEpisodeAction())->execute();
                break;
            case "display-liste-episodes":
                $res = (new DisplayListeEpisodesAction())->execute();
                break;
            case $track :
                $res = (new ActiveCompte())->execute();
                break;
            case "display-profil":
                $res = (new DisplayProfilAction())->execute();
                break;
            case "set-favoris" :
                $res = (new SetFavorisAction())->execute();
                break;
            case "ajouter-commentaire" :
                $res = (new AddCommentAction())->execute();
                break;
            case "rechercher" :
                $res = (new RechercherCatalogueAction())->execute();
                break;
            case "filtrer-catalogue" :
                $res = (new FiltrerCatalogueAction())->execute();
                break;
            default:
                $res = "<p>Bienvenue dans la version wish de Netflix !</p>";
                if (isset($_SESSION['user'])){
                    $res .= (new DisplayHomeAction())->execute();
                    
                }
        }

        echo    "<div id='content'>
                    $res
                </div>";

    }

}


?>