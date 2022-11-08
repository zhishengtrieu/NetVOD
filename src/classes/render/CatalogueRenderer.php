<?php

namespace netvod\render;

use netvod\video\catalogue\Catalogue;

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
        foreach ($this->catalogue->series as $serie){
            $renderer = new SerieRenderer($serie);
            $html .= "<a href='?action=display-liste-episodes&id=$serie->id'> ".$renderer->render(Renderer::COMPACT)."</a>";
        }
        return $html;
    }

    private function renderLong():string{
        $html = "";
        return $html;
    }
}