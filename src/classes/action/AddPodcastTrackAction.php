<?php
declare(strict_types=1);
namespace netvod\action;
use netvod\audio\lists\Playlist;
use netvod\audio\tracks\PodcastTrack;
use netvod\render\AudioListRenderer;

class AddPodcastTrackAction extends Action{
    public function execute(): string{
        $res = "";
        if($this->http_method == 'POST'){
            if (($_FILES['userfile']['error'] === UPLOAD_ERR_OK)
            && ($_FILES['userfile']['type'] === 'audio/mpeg') ){
                $dest = 'audio/' . uniqid() . '.mp3';
                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $dest)) {
                    $res = "téléchargement terminé avec succès<br>";
                    $titre = filter_var($_POST['titre'], FILTER_SANITIZE_STRING);
                    $duree = filter_var($_POST['duree'], FILTER_SANITIZE_NUMBER_INT) > 0 ? filter_var($_POST['duree'], FILTER_SANITIZE_NUMBER_INT) : 0;
                    $genre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
                    $auteur = filter_var($_POST['auteur'], FILTER_SANITIZE_STRING);
                    $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
                    $piste = new PodcastTrack($titre, $dest);
                    $piste->duree = (int) $duree;
                    $piste->genre = $genre;
                    $piste->auteur = $auteur;
                    $piste->date = $date;
                    $playlist = (unserialize($_SESSION['playlist']));
                    $playlist->ajouterPiste($piste);
                    $res .= (new AudioListRenderer($playlist))->render();
                    
                } else {
                    $res = "hum, hum téléchargement non valide<br>";
                }
            }else{
                $res = "téléchargement non valide<br>";
            }
        }else{
            $res = <<<END
            <form method="post" action="?action=add-podcasttrack" enctype="multipart/form-data">
                <input type="file" name="userfile">
                <input type="email" name="email" placeholder="Ton email">
                <input type="text" name="titre" placeholder="Titre">
                <input type="number" name="duree" placeholder="Duree">
                <input type="text" name="genre" placeholder="Genre">
                <input type="text" name="auteur" placeholder="Auteur">
                <input type="date" name="date" placeholder="Date">
                <input type="submit" value="Ajouter la piste"> 
            </form>
            END;
        }
        return $res;
    }
    
    
}


?>