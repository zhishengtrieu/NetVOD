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
                    $query = "select * from episode where serie_id = ?";
                    $st = ConnectionFactory::$db->prepare($query);
                    $st->bindParam(1,$_GET['id']);
                    $st->execute();
                    $query2 = "select titre from serie where id = ?";
                    $st2 = ConnectionFactory::$db->prepare($query2);
                    $st2->bindParam(1,$_GET['id']);
                    $st2->execute();
                    $row2 = $st2 -> fetch(PDO::FETCH_ASSOC);
                    $serie = new Serie($_GET['id'],$row2['titre']);
                    foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        $id =$row['id'];
                        $numero =$row['numero'];
                        $titre=$row['titre'];
                        $resume=$row['resume'];
                        $duree=$row['duree'];
                        $path=$row['file'];
                        $serieId=$row['serie_id'];
                        $episode = new Episode(intval($id),intval($numero),$titre,$resume,intval($duree),$path,intval($serieId));
                        $serie->ajouterEpisode($episode);
                    }
                    $res = (new SerieRenderer($serie))->render(Renderer::LONG);
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