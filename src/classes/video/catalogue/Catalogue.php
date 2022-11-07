<?php
/**
 * Liste de series
 */
namespace netvod\video\catalogue;
use netvod\video\Serie;
class Catalogue{

    private array $series;

    public function __construct(){
        $this->series = array();
    }

    public function ajouterSerie(Serie $serie){
        $this->series[] = $serie;
    }

    public function getSeries(){
        return $this->series;
    }

}
?>