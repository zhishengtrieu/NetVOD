<?php

namespace netvod\video\tris;

use netvod\db\ConnectionFactory;
use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;
use netvod\video\catalogue\Catalogue;
use netvod\video\serie\Serie;
use \PDO;
class TriMoyennePlusPetite implements Tri
{
    // cette fonction permettera de trier les series du catalogue par moyenne la plus petite a la plus grande
    public function trier(): string
    {
        $res = "";
        //on créé un nouveau catalogue
        $catalogue = new Catalogue();
        //requete sql permettant de recuperer l'id et le titre et la moyenne des series et de les trier par de la pire moyenne a la meilleure
        $query = "select id,titre, avg(note) from commentaire
                    inner join serie on commentaire.serie_id = serie.id
                    group by id,titre
                    order by avg(note) asc";
        $st = ConnectionFactory::$db->prepare($query);
        $st->execute();
        //pour chaque reponse à la requete sql(trier dans l'ordre croissant) on creer une serie et on l'ajoute au catalogue
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