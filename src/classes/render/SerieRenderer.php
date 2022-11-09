<?php
declare(strict_types=1);
namespace netvod\render;
use netvod\db\ConnectionFactory;
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
        return $html;
    }

    private function renderCompact():string{
        $serie = Serie::find($this->serie->id);
        $html = "
        <div class='serie'>
            <div class='serie_title'>
                <li>{$this->serie->titre}</li>
            </div>
            <img src='img/$serie->img' height='300' width='400'>
        </div>
        ";
        return $html;
    }

    private function renderLong():string{
        $html = "<h1>{$this->serie->titre}</h1>
        <h2>{$this->serie->descriptif}</h2>
        <h3>Date de sortie : {$this->serie->annee}</h3>
        <h3>Date d'ajout : {$this->serie->dateAjout}</h3>
        <h3>Nombre d'épisodes : {$this->serie->nbEpisodes}</h3>
        <h3>Genres : ";
        $html .= implode(", ", $this->serie->genres) . "</h3>
        <h3>Public : ";
        $html .= implode(", ", $this->serie->public) . "</h3>";
        //on doit permettre a l'user d'ajouter ou retirer la serie a ses favoris
        $user = unserialize($_SESSION['user']);
        //on verifie si la serie est deja dans les favoris de l'user
        //si on oui le bouton dit qu'il le retirera des favoris sinon il indique qu'il l'ajoutera
        $action = $user->favoris($this->serie->id) ? "Retirer de" : "Ajouter à";
        //on donne le formulaire 
        $html.= <<<END
        <form action="?action=set-favoris" method="POST">
            <input type="hidden" name="id" value="{$this->serie->id}">
            <input type="submit" value="$action mes préférences">
        </form>
        END;
        foreach ($this->serie->episodes as $ep){
            $renderer = new EpisodeRenderer($ep);
            $html .= $renderer->render(Renderer::COMPACT);
        }
        return $html;
    }
}
?>