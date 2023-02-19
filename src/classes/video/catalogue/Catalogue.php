<?php
/**
 * Liste de series
 */
namespace netvod\video\catalogue;
use netvod\exception\InvalidPropertyNameException;
use netvod\video\serie\Serie;
use netvod\db\ConnectionFactory;
use PDO;
class Catalogue{

    private array $series;

    public function __construct(){
        ConnectionFactory::makeConnection();
        $this->series = array();
        $query = "select id,titre from serie";
        $st = ConnectionFactory::$db->prepare($query);
        $st->execute();
        //pour chaque id on l'ajoute la serie au catalogue
        foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $id = (int) $row['id'];
            $this->ajouterSerie(Serie::find($id));
        }
    }

    public function ajouterSerie(Serie $serie){
        $this->series[] = $serie;
    }

    public function viderCatalogue(){
        $this->series = array();
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