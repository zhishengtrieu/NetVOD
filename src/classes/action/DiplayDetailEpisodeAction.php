<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\EpisodeRenderer;
use netvod\render\Renderer;
use netvod\render\SerieRenderer;
use netvod\video\episode\Episode;
use netvod\video\serie\Serie;

class DiplayDetailEpisodeAction extends Action
{

    public function execute(): string
    {
        ConnectionFactory::makeConnection();
        $res = "";
        if ($this->http_method == 'GET') {
            if (isset($_SESSION['user'])) {
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $episode= Episode::find($id);
                    $res = (new EpisodeRenderer($episode))->render(Renderer::LONG);
                }else{
                    echo('id invalide');
                }
            }else{
                echo('Il faut se connecter avant de consulter les series du catalogue');
            }
        }
        return $res;
    }
}