<?php
/**
 * Une serie est une liste d'episodes
 */
namespace netvod\video\Serie;
use netvod\video\Episode;
class Serie{

    private string $titre;
    private string $genre;
    private string $public;
    private string $resume;
    private string $dateSortieFilm;
    private string $dateSortiePlateforme;
    private int $nbEpisode;

    public function __construct(string $titre, string $genre){
        $this->titre = $titre;
        $this->genre = $genre;
    }

    public function __set($attribut, $valeur){
        if (property_exists($this, $attribut)){
            if ($attribut == "titre" || $attribut == "genre" || $attribut == "public" || $attribut == "resume" || $attribut == "dateSortieFilm" || $attribut == "dateSortiePlateforme" || $attribut == "nbEpisode"){
                $this->$attribut = $valeur;
            }else{
                throw new NonEditablePropertyException($attribut);
            }
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
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