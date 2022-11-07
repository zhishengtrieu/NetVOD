<?php
declare(strict_types=1);
namespace netvod\action;
use netvod\audio\lists\Playlist;
use netvod\render\AudioListRenderer;

class AddPlaylistAction extends Action{
    public function execute(): string{
        $res = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
            $playlist = new Playlist($nom);
            $_SESSION['playlist'] = serialize($playlist);
            $res = (new AudioListRenderer($playlist))->render();
            $res .= '<a href="?action=add-podcasttrack">Ajouter une piste</a>';
        }else{
            $res = <<<END
            <form method="post" action="?action=add-playlist">
            <input type="text" name="nom" placeholder="Nom de la playlist">
            <input type="submit" value="Creer la playlist"> 
            </form>
            END;
        }
        return $res;
    }
    
    
}


?>