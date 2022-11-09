<?php
declare(strict_types=1);
namespace netvod\dispatch;
use netvod\action\ActiveCompte;
use netvod\action\DisplayEpisodeAction;
use netvod\render\Header;
use netvod\action\DisplayListeEpisodesAction;
use netvod\action\DisplayCatalogueAction;
use netvod\action\SigninAction;
use netvod\action\AddUserAction;
use netvod\action\DisplayProfileAction;
use netvod\action\AddSerieFavorisAction;
use netvod\action\AddCommentAction;
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
                break;
            case "display-profil":
                $res = (new DisplayProfileAction())->execute();
                break;
            case "ajouter-favoris" :
                $res = (new AddSerieFavorisAction())->execute();
                break;
            case "ajouter-commentaire" :
                $res = (new AddCommentAction())->execute();
                break;
            default:
                $res =  "<p>Bienvenue dans la version wish de Netflix !</p>";
        }

        echo    "<div id='content'>
                    $res
                </div>";

    }

}


?>