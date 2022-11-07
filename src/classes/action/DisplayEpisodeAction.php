<?php
declare(strict_types=1);
namespace netvod\action;
use netvod\video\episode\Episode;
use netvod\render\EpisodeRenderer;
use netvod\user\User;
use netvod\exception\AccessControlException;

class DisplayEpisodeAction{
    public function execute(): string{
        $res = "";
        if($this->http_method == 'POST'){
            if (isset($_POST['id'])){
                $id = (int) filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
                if (isset($_SESSION['user'])){
                    $user = unserialize($_SESSION['user']);
                    try{
                        Auth::checkPlaylist($id);
                        $episode = Episode::find($id);
                        $res = (new EpisodeRenderer($episode))->render();                     
                        /**
                        * 8. Lors du visionnage d’un épisode, ajouter automatiquement la série à la liste « en
                        * cours » de l’utilisateur
                        * Lorsqu’un épisode est visionné, la série contenant l’épisode est automatiquement ajoutée à la
                        * liste « en cours » de l’utilisateur ; Cette liste apparaît sur la page d’accueil de l’utilisateur, de
                        * façon similaire à la liste de préférence. 
                        */
                        $user->addSerieEnCours($episode->getSerie());
                    }catch(AccessControlException $e){
                        $res = $e->getMessage();
                    }
                    
                }
            }else{
                //doit donner index.php?action=displayplaylist&id=1
                $res = <<<HTML
                <form action="?display-episode" method="POST">
                    <input type="number" name="id" placeholder="id">
                    <input type="submit" value="Afficher">
                </form>
                HTML;
            }
        }
        return $res;
    }
}
?>

