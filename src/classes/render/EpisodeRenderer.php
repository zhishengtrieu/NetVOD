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

    private function renderCompact():string{
        $html = "
        <div class='episode'>
            <div class='episode_title'>
                <h3>
                    <li>
                    <a href='?action=display-episode&id={$this->episode->id}'>{$this->episode->titre}</a>
                    </li>
                </h3>
                <p>numero de l episode: {$this->episode->numero}, duree: {$this->episode->duree} minutes</p>
                <video controls width='300'>
                    <source src='video/{$this->episode->path}' type='video/mp4'>
                </video>
            </div>
        </div>";
        return $html;
    }

    private function renderLong():string{
        $html = "
        <div class='episode'>
            <div class='episode_title'>
                <h3>{$this->episode->titre}</h3>
                <h4>{$this->episode->resume}</h4>
                <p>L'episode dure: {$this->episode->duree} minutes</p>
                <video controls width=\"600\">
                    <source src=\"video/{$this->episode->path}\" type=\"video/mp4\">
                </video>
        </div>
        ";
        $query = "select serie_id from episode where id = ?";
        $id = $this->episode->id;
        $st = ConnectionFactory::$db->prepare($query);
        $st -> bindParam(1,$id);
        $st->execute();
        $row= $st->fetch(PDO::FETCH_ASSOC);
        $id_serie = $row['serie_id'];
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