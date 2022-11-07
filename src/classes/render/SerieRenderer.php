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
                <h3>{$this->serie->titre}</h3>
            </div>

        ";
        return $html;
    }

    private function renderLong():string{
        $html = "";
        return $html;
    }
}
?>