<?php

declare(strict_types=1);
namespace netvod\action;

use netvod\render\CatalogueRenderer;
use netvod\video\serie\Serie;
use netvod\video\catalogue\Catalogue;
use netvod\db\ConnectionFactory;
use PDO;


class AfficherCatalogueAction extends Action{

    public function execute(): string{
        ConnectionFactory::makeConnection();
        $res = "";
        if ($this->http_method == 'GET') {
            if (isset($_SESSION['user'])) {
                    $catalogue = new Catalogue();
                    $query = "select id,titre from serie";
                    $st = ConnectionFactory::$db->prepare($query);
                    $st->execute();
                    foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        $id = $row['id'];
                        $titre = $row['titre'];
                        $serie = new Serie(intval($id),$titre);
                        $catalogue->ajouterSerie($serie);
                    }
                    $res = (new CatalogueRenderer($catalogue))->render();
            }
        }
        return $res;
    }
}


?>


