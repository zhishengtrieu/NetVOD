<?php
declare(strict_types=1);
namespace netvod\render;
use netvod\video\episode\Episode;

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
        return $this->episode->titre;
    }

    private function renderLong():string{
        $html = "";
        return $html;
    }
}
?>