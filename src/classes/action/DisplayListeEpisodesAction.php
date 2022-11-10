<?php
declare(strict_types=1);

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\Renderer;
use netvod\render\SerieRenderer;
use netvod\video\episode\Episode;
use netvod\video\serie\Serie;
use \PDO;

class DisplayListeEpisodesAction extends Action{

    //fonction permettant d'afficher la liste d'episodes d'une serie
    public function execute(): string{
        ConnectionFactory::makeConnection();
        $res = "";
        if ($this->http_method == 'GET') {
            if (isset($_SESSION['user'])) {
                if (isset($_GET['id'])) {
                    //on recupere l'id de la serie
                    $id = $_GET['id'];
                    //on cherche les episodes de la serie correspondant a l'id
                    $serie = Serie::find((int) $id);
                    //on execute la methode long du renderer de serie
                    $res = (new SerieRenderer($serie))->render(Renderer::LONG);
                }else{
                    $res .=('id invalide');
                }
            }else{
                $res .= 'Il faut se connecter avant de consulter la liste des épisodes de la série';
            }
        }
        return $res;
    }

}