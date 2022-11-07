<?php
declare(strict_types=1);
namespace netvod\dispatch;
use netvod\action\DisplayCatalogueAction;
use netvod\action\DisplayListeEpisodesAction;
use netvod\render\Header;
use netvod\action\SigninAction;
use netvod\action\AddUserAction;
use netvod\action\DisplayEpisodeAction;
class Dispatcher{
    public function run(): void{
        Header::render();
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
            default:
                echo "Bienvenue !";
        }
               
        echo <<<END
        </body>
        </html>
        END;
    }

}


?>