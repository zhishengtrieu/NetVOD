<?php
/**
 * Liste de series
 */
namespace netvod\video\catalogue;
use netvod\exception\InvalidPropertyNameException;
use netvod\video\serie\Serie;
class Catalogue{

    private array $series;

    public function __construct(){
        $this->series = array();
        $query = "select id,titre from serie";
        $st = ConnectionFactory::$db->prepare($query);
        $st->execute();
        //pour chaque titre et id on créer une serie puis on l'ajoute au catalogue
        foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $id = $row['id'];
            $titre = $row['titre'];
            $serie = new Serie(intval($id),$titre);
            $catalogue->ajouterSerie($serie);
        }
    }

    public function ajouterSerie(Serie $serie){
        $this->series[] = $serie;
    }

    public function __get($attribut){
        if (property_exists($this, $attribut)){
            return $this->$attribut;
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }

}
?>