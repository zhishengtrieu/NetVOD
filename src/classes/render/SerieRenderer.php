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
        $html = "<h1>{$this->serie->titre}</h1>";
        foreach ($this->serie->episodes as $ep){
            $renderer = new EpisodeRenderer($ep);
            $html .= "<li>".$renderer->render(Renderer::COMPACT)."</li>";
        }
        return $html;
    }
}
?>