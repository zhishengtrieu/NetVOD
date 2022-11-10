<?php
declare(strict_types=1);
namespace netvod\video\tris;

use netvod\db\ConnectionFactory;
use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;
use netvod\video\catalogue\Catalogue;
use netvod\video\serie\Serie;
use \PDO;

class TriAntiAplha implements Tri{

    // cette fonction permettera de trier les series du catalogue par ordre inverse de l'ordre alphabetique sur le nom de la serie
    public function trier(): string{
        $res = "";
        //on créé un nouveau catalogue
        $catalogue = new Catalogue();
        //requete sql permettant de recuperer l'id et le titre des series et de les trier par ordre anti-aplhabetique sur le nom
        $query = "select id,titre from serie order by titre desc";
        $st = ConnectionFactory::$db->prepare($query);
        $st->execute();
        //pour chaque reponse à la requete sql(trier dans l'ordre decroissant) on creer une serie et on l'ajoute au catalogue
        foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $id = $row['id'];
            $titre = $row['titre'];
            $serie = new Serie(intval($id),$titre);
            $catalogue->ajouterSerie($serie);
        }
        //on affiche le catalogue
        $res .= (new CatalogueRenderer($catalogue))->render(Renderer::COMPACT);
        return $res;
    }
}