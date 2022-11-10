<?php
declare(strict_types=1);

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;
use netvod\video\catalogue\Catalogue;
use netvod\video\serie\Serie;
use \PDO;

class RechercherCatalogueAction extends Action{

    public function execute(): string{
        $res = "";
        if ($this->http_method == 'POST') {
            if (isset($_SESSION['user'])) {
                $catalogue = new Catalogue();
                $recherche = filter_var($_POST['recherche'], FILTER_SANITIZE_STRING);
                $sql = "select id, titre from serie where titre like '%$recherche%' or descriptif like '%$recherche%'";
                ConnectionFactory::makeConnection();
                $stmt = ConnectionFactory::$db->prepare($sql);
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