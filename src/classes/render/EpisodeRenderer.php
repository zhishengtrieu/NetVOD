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
        $html = "
        <div class='episode'>
            <div class='episode_title'>
                <h3>
                    <li>
                    <a href='?action=display-detail-episode&id={$this->episode->id}'>{$this->episode->titre}</a>
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
        return $html;
    }
}
?>