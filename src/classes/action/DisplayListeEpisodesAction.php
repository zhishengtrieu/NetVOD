<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\Renderer;
use netvod\render\SerieRenderer;
use netvod\video\episode\Episode;
use netvod\video\serie\Serie;
use \PDO;

class DisplayListeEpisodesAction extends Action{

    public function execute(): string{
        ConnectionFactory::makeConnection();
        $res = "";
        if ($this->http_method == 'GET') {
            if (isset($_SESSION['user'])) {
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $serie = Serie::find($id);
                    $res = (new SerieRenderer($serie))->render(Renderer::LONG);
                }else{
                    $res .=('id invalide');
                }
            }else{
                $res .= 'Il faut se connecter avant de consulter les series du catalogue';
            }
        }
        return $res;
    }
}