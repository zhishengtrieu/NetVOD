<?php
declare(strict_types=1);

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
                //on verifie que les deux champs ne soient pas vides
                if(!($genre === "" && $public === "")){
                    //on vide le catalogue de base
                    $catalogue->viderCatalogue();
                    if($_POST['genre'] === "" || $_POST['public'] ==="") {
                        $sql = "SELECT id from serie 
                                    inner join serie_genre on serie.id = serie_genre.id_serie 
                                    inner join genre on serie_genre.id_genre = genre.id_genre 
                                    where libelle_genre = ? 
                                    union 
                                    select id from serie 
                                    inner join serie_public on serie.id = serie_public.id_serie 
                                    inner join public on serie_public.id_public = public.id_public 
                                    where libelle_public = ?";
                    }else{
                        $sql = "SELECT s.id 
                                    FROM serie s 
                                    INNER JOIN (
                                        SELECT sg.id_serie 
                                        FROM serie_genre sg 
                                        INNER JOIN genre g ON sg.id_genre = g.id_genre 
                                        WHERE g.libelle_genre = ?
                                    ) g ON s.id = g.id_serie 
                                    INNER JOIN (
                                        SELECT sp.id_serie 
                                        FROM serie_public sp 
                                        INNER JOIN public p ON sp.id_public = p.id_public 
                                        WHERE p.libelle_public = ?
                                    ) p ON s.id = p.id_serie 
                                    GROUP BY s.id";
                    }
                    ConnectionFactory::makeConnection();
                    $stmt = ConnectionFactory::$db->prepare($sql);
                    $stmt -> bindParam(1,$genre);
                    $stmt -> bindParam(2,$public);
                    $stmt->execute();
                    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        $id = $row['id'];
                        $serie = Serie::find(intval($id));
                        $catalogue->ajouterSerie($serie);
                    }
                }
                $res .= (new CatalogueRenderer($catalogue))->render(Renderer::COMPACT);
            }else{
                $res .='Il faut se connecter avant de consulter les series du catalogue';
            }

        }
        return $res;
    }

}