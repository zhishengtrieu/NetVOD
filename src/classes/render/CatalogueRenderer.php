<?php

namespace netvod\render;

use netvod\db\ConnectionFactory;
use netvod\video\catalogue\Catalogue;
use netvod\video\serie\Serie;
use \PDO;
class CatalogueRenderer implements Renderer{

    private Catalogue $catalogue;

    public function __construct(Catalogue $catalogue){
        $this->catalogue = $catalogue;
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
        $html = "<h1>Catalogue</h1>";
        $html .= <<<HTML
            <form action="?action=rechercher" method="post">
                <input type="string" name="recherche" placeholder="recherche">
                <input type="submit" value="Rechercher">
            </form>
            HTML;
        $html .= <<<HTML
            <form action="?action=afficherCatalogue" method="post">
                <select name='tris'>
                    <option value="1">Trier par titre alphabétique</option>
                    <option value="2">Trier par titre anti-alphabétique</option>
                    <option value="3">Trier par plus grand nombre d'épisodes</option>
                    <option value="4">Trier par plus petit nombre d'épisodes</option>
                    <option value="5">Trier par moyenne de serie la plus élevée</option>
                    <option value="6">Trier par moyenne de serie la plus basse</option>
                    <option value="7">Trier par date d'ajout croissante</option>
                    <option value="8">Trier par date d'ajout decroissante</option>
                    <option value="9">Trier les séries de la plus ancienne à la plus récente</option>
                    <option value="10">Trier les séries de la plus récente à la plus ancienne</option>


                </select>
          <input type='submit' value='trier'>
        </form>
        HTML;
        $html .= <<<HTML
            <form action="?action=filtrer-catalogue" method="post">
                <select name='genre'>
                    <option value="">Selectionner un genre</option>
                    <option value="action">Action</option>
                    <option value="thriller">Thriller</option>
                    <option value="anime">Anime</option>
                    <option value="comedie">Comedie</option>
                    <option value="romance">Romance</option>
                    <option value="horreur">Horreur</option>
                </select>
                
                <select name='public'>
                    <option value="">Selectionner un public</option>
                    <option value="enfants">Enfants</option>
                    <option value="adolescents">Adolescents</option>
                    <option value="familles">Familles</option>
                    <option value="adultes">Adultes</option>
                </select>
                <input type='submit' value='filtrer'>
            </form>
            HTML;
        foreach ($this->catalogue->series as $serie){
            $renderer = new SerieRenderer($serie);
            $html .= "<a href='?action=display-liste-episodes&id=$serie->id'>".$renderer->render(Renderer::COMPACT)."</a>";
        }
        return $html;
    }

    private function renderLong():string{
        $html = "";
        return $html;
    }
}