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