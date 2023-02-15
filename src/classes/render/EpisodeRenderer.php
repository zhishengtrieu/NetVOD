<?php
declare(strict_types=1);
namespace netvod\render;
use netvod\db\ConnectionFactory;
use netvod\video\episode\Episode;
use \PDO;
class EpisodeRenderer implements Renderer{
    private Episode $episode;

    public function __construct(Episode $episode){
        $this->episode = $episode;
    }

    public function render(int $selector):string{
        $html = "";
        switch($selector){
            case Renderer::COMPACT:
                $html = $this->renderCompact();
                break;
            case Renderer::LONG:
                $html = $this->renderLong();
                break;
        }
        return $html;
    }

    //affichage en mode court
    private function renderCompact():string{
        //affiche le titre en mode lien et la video
        $html = "
        <div class='episode'>
            <a href='?action=display-episode&id={$this->episode->id}'>
                <h3>{$this->episode->titre}</h3>
                <p>Episode : {$this->episode->numero}, durée : {$this->episode->duree} minutes</p>
                <img src='img/{$this->episode->img}'>
            </a>
        </div>";
        return $html;
    }

    //affichage en mode long
    private function renderLong():string{
        //affiche le titre de l'episode, le resume, la duree, et la video d'un episode
        $html = "
                <h3>{$this->episode->titre}</h3>
                <h4>{$this->episode->resume}</h4>
                <p>L'episode dure: {$this->episode->duree} minutes</p>
                <video controls width=\"600\">
                    <source src=\"video/{$this->episode->path}\" type=\"video/mp4\">
                </video>
        ";
        //on selectionne l'id de la serie correspondant a l'id de l'episode
        $query = "select serie_id from episode where id = ?";
        $id = $this->episode->id;
        $st = ConnectionFactory::$db->prepare($query);
        $st -> bindParam(1,$id);
        $st->execute();
        $row= $st->fetch(PDO::FETCH_ASSOC);
        $id_serie = $row['serie_id'];
        //on fait un formualaire pour chosir la note et enregistrer un commentaire
        $html .= <<<END
                <form action="?action=add-comment&id_serie=$id_serie" method="POST">
                    <input type="string" name="commentaire" placeholder="comment">
                    <select name="note">
                        <option value="1">1 etoile</option>
                        <option value="1.5">1.5 etoile</option>
                        <option value="2">2 etoiles</option>
                        <option value="2.5">2.5 etoiles</option>
                        <option value="3">3 etoiles</option>
                        <option value="3.5">3.5 etoiles</option>
                        <option value="4">4 etoiles</option>
                        <option value="4.5">4.5 etoiles</option>
                        <option value="5">5 etoiles</option>
                    </select>
                    <input type="submit" value="Enregistrer le commentaire">
                </form>
            END;
        return $html;
    }
}
?>