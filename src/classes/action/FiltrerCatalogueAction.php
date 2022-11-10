<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;
use netvod\video\catalogue\Catalogue;
use netvod\video\serie\Serie;
use \PDO;

class FiltrerCatalogueAction extends Action{

    public function execute(): string{
        $res = "";
        if ($this->http_method == 'POST') {
            if (isset($_SESSION['user'])) {
                $catalogue = new Catalogue();
                $genre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
                $public = filter_var($_POST['public'], FILTER_SANITIZE_STRING);
                if($_POST['genre'] === "" || isset($_POST['public']) ==="") {
                    $sql = "select id, titre from serie 
                inner join serie_genre on serie.id = serie_genre.id_serie 
                inner join genre on serie_genre.id_genre = genre.id_genre 
                where libelle_genre = ? 
                union 
                select id, titre from serie 
                inner join serie_public on serie.id = serie_public.id_serie 
                inner join public on serie_public.id_public = public.id_public 
                where libelle_public = ?";
                }
               else{
                    $sql = "select id, titre from serie 
                inner join serie_genre on serie.id = serie_genre.id_serie 
                inner join genre on serie_genre.id_genre = genre.id_genre 
                where libelle_genre = ? 
                intersect 
                select id, titre from serie 
                inner join serie_public on serie.id = serie_public.id_serie 
                inner join public on serie_public.id_public = public.id_public 
                where libelle_public = ?";
                }
                ConnectionFactory::makeConnection();
                $stmt = ConnectionFactory::$db->prepare($sql);
                $stmt -> bindParam(1,$genre);
                $stmt -> bindParam(2,$public);
                $stmt->execute();
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $id = $row['id'];
                    $titre = $row['titre'];
                    $serie = new Serie(intval($id),$titre);
                    $catalogue->ajouterSerie($serie);
                }
                $res .= (new CatalogueRenderer($catalogue))->render(Renderer::COMPACT);
            }else{
                $res .='Il faut se connecter avant de consulter les series du catalogue';
            }

        }
        return $res;
    }

}