<?php
declare(strict_types=1);
namespace netvod\video\tris;

use netvod\db\ConnectionFactory;
use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;
use netvod\video\catalogue\Catalogue;
use netvod\video\serie\Serie;
use \PDO;

class TriNbGrandEpisode implements Tri{

    // cette fonction permettera de trier les series du catalogue par nombre d'episode du plus grand au plus petit
    public function trier(): string{
        $res = "";
        //on créé un nouveau catalogue
        $catalogue = new Catalogue();
        //requete sql permettant de recuperer l'id et le titre et le nombre d'episode et on tri du plus grand au plus petit
        $query = "select serie.id,serie.titre, count(episode.id)from serie 
                inner join episode on serie.id = episode.serie_id 
                group by serie.id,titre order by count(episode.id) desc";
        $st = ConnectionFactory::$db->prepare($query);
        $st->execute();
        //pour chaque reponse à la requete sql(trier dans l'ordre decroissant) on creer une serie et on l'ajoute au catalogue
        foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $id = $row['id'];
            $titre = $row['titre'];
            $serie = new Serie(intval($id),$titre);
            $catalogue->ajouterSerie($serie);
        }
        //on affiche le catalogue et on le retourne
        $res .= (new CatalogueRenderer($catalogue))->render(Renderer::COMPACT);
        return $res;
    }
}