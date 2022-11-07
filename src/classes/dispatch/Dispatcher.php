<?php
declare(strict_types=1);
namespace netvod\dispatch;
use netvod\action\AfficherCatalogueAction;
use netvod\action\ActiveCompte;
use netvod\render\Header;
use netvod\action\SigninAction;
use netvod\action\AddUserAction;
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
                echo (new AfficherCatalogueAction())->execute();
                break;
            case "display-episode":
                echo (new DisplayEpisodeAction())->execute();
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