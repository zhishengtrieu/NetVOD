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
        $html .= <<<END
            <form action="?action=rechercher" method="post">
                <input type="string" name="recherche" placeholder="recherche">
                <input type="submit" value="Rechercher">
            </form>
            END;
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