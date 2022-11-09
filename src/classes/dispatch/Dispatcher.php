<?php
declare(strict_types=1);
namespace netvod\dispatch;
use netvod\action\ActiveCompte;
use netvod\action\DiplayDetailEpisodeAction;
use netvod\render\Header;
use netvod\action\DisplayListeEpisodesAction;
use netvod\action\DisplayCatalogueAction;
use netvod\action\SigninAction;
use netvod\action\AddUserAction;
use netvod\action\DisplayProfileAction;
use netvod\action\AddSerieFavorisAction;
class Dispatcher{
    public function run(): void{
        Header::render();
        
        $track= isset($_COOKIE['token']) ? $_COOKIE['token'] : "token";
        
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        switch($action){
            case "add-user":
                echo (new AddUserAction())->execute();
                break;
            case "signin" :
                echo (new SigninAction())->execute();
                break;
            case "afficherCatalogue" :
                echo (new DisplayCatalogueAction())->execute();
                break;
            case "display-episode":
                echo (new DisplayEpisodeAction())->execute();
                break;
            case "display-liste-episodes":
                echo (new DisplayListeEpisodesAction())->execute();
                break;
            case $track :
                echo (new ActiveCompte())->execute();
                break;
            case "display-detail-episode":
                echo (new DiplayDetailEpisodeAction())->execute();
                break;
            case "display-profil":
                echo (new DisplayProfileAction())->execute();
                break;
            case "ajouter-favoris" :
                echo (new AddSerieFavorisAction())->execute();
                break;
            default:
                echo "Bienvenue !";
        }
    }

}


?>