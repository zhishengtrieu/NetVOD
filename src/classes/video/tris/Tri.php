<?php
declare(strict_types=1);
namespace netvod\video\tris;

use netvod\exception\InvalidPropertyNameException;
use netvod\db\ConnectionFactory;
use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;
use netvod\video\catalogue\Catalogue;
use netvod\video\serie\Serie;
use \PDO;
// interface qui implementera chacun des tris
abstract class Tri{
    protected string $query;

    //la methode trier sera defini dans chanque classe implementant l'interface tri selon le tri voulu (via une requete sql)
    public function trier():string{
        $res = "";
        //on crée un nouveau catalogue
        $catalogue = new Catalogue();
        //on vide le catalogue de base
        $catalogue->viderCatalogue();
        $st = ConnectionFactory::$db->prepare($this->query);
        $st->execute();
        //pour chaque reponse à la requete sql(trier dans l'ordre croissant) on ajoute la serie au catalogue
        foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $id = $row['id'];
            $serie = Serie::find(intval($id));
            $catalogue->ajouterSerie($serie);
        }
        //on affiche le catalogue et on le retourne
        $res .= (new CatalogueRenderer($catalogue))->render(Renderer::COMPACT);
        return $res;
    }

    public function __get($attribut){
        if (property_exists($this, $attribut)){
            return $this->$attribut;
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }

    public function __set($attribut, $valeur){
        if (property_exists($this, $attribut)){
            $this->$attribut = $valeur;
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }

}