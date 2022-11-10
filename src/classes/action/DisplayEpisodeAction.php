<?php
declare(strict_types=1);
namespace netvod\action;
use netvod\video\episode\Episode;
use netvod\video\serie\Serie;
use netvod\render\EpisodeRenderer;
use netvod\render\Renderer;
use netvod\user\User;
use netvod\exception\AccessControlException;

class DisplayEpisodeAction extends Action{
    public function execute(): string{
        $res = "";
        if($this->http_method == 'GET'){
            if (isset($_GET['id'])){
                $id = (int) $_GET['id'];
                if (isset($_SESSION['user'])){
                    $user = unserialize($_SESSION['user']);
                    try{
                        $episode = Episode::find($id);
                        $res = (new EpisodeRenderer($episode))->render(Renderer::LONG);                     
                        /*
                        Lors du visionnage d’un épisode, ajouter automatiquement la série à 
                        la liste « en cours » de l’utilisateur
                        Lorsqu’un épisode est visionné, la série contenant l’épisode est automatiquement ajoutée à la
                        liste « en cours » de l’utilisateur ; Cette liste apparaît sur la page d’accueil de l’utilisateur, de
                        façon similaire à la liste de préférence. 
                        */
                        $serie = Serie::find($episode->idSerie);
                        $user->addSerieEnCours($serie);
                        if ($episode->numero == $serie->nbEpisodes){
                            /*
                            Lorsqu’un épisode est le dernier d’une série, la série est automatiquement ajoutée à la liste
                            « visionnée » de l’utilisateur
                            */
                            $user->removeSerieEnCours($serie);
                            $user->addSerieVisionnee($serie);
                        }
                        $_SESSION['user'] = serialize($user);
                    }catch(AccessControlException $e){
                        $res = $e->getMessage();
                    }
                    
                }else{
                    echo('Il faut se connecter avant de consulter les series du catalogue');
                }
            }else{
                echo('id invalide');
            }
        }
        return $res;
    }
}
?>

