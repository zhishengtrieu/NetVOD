<?php
declare(strict_types=1);
namespace netvod\render;
use netvod\video\serie\Serie;

class SerieRenderer implements Renderer{
    private Serie $serie;

    public function __construct(Serie $serie){
        $this->serie = $serie;
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
        //on doit permettre a l'user d'ajouter la serie a ses favoris
        $html.= <<<END
        <form action="?action=ajouter-favoris" method="POST">
            <input type="hidden" name="id" value="{$this->serie->id}">
            <input type="submit" value="Ajouter à mes préférences">
        </form>
        END;
        return $html;
    }

    private function renderCompact():string{
        $html = "
        <div class='serie'>
            <div class='serie_title'>
                <li>{$this->serie->titre}</li>
            </div>
        </div>
        ";
        return $html;
    }

    private function renderLong():string{
        $html = "<h1>{$this->serie->titre}</h1>
        <h2>{$this->serie->descriptif}</h2>
        <h3>Date de sortie :{$this->serie->annee}</h3>
        <h3>Date d'ajout :{$this->serie->dateAjout}</h3>
        <h3>Nombre d'épisodes :{$this->serie->nbEpisodes}</h3>
        <h3>Genres : ";
        foreach($this->serie->genres as $genre){
            $html.= $genre->nom.", ";
        }
        $html .= "</h3>";
        foreach ($this->serie->episodes as $ep){
            $renderer = new EpisodeRenderer($ep);
            $html .= $renderer->render(Renderer::COMPACT);
        }
        return $html;
    }
}
?>