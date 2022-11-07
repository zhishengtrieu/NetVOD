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
        $html = "Catalogue";
        foreach ($this->catalogue as $serie){
            $renderer = new SerieRenderer();
            $html .= $renderer."<br>";
        }
        return $html;
    }

    private function renderLong():string{
        $html = "";
        return $html;
    }
}