<?php
/**
 * Une serie est une liste d'episodes
 */
namespace netvod\video\Serie;
use netvod\video\Episode;
use netvod\exception\InvalidPropertyNameException;
use netvod\exception\NonEditablePropertyException;
class Serie{

    private int $id;
    private string $titre;
    private string $genre;
    private string $public;
    private string $resume;
    private string $dateSortieFilm;
    private string $dateSortiePlateforme;
    private int $nbEpisode;
    private array $episodes;

    public function __construct(int $id, string $titre, string $genre){
        $this->id = $id;
        $this->titre = $titre;
        $this->genre = $genre;
        $this->nbEpisode = 0;
        $this->episodes = array();
    }

    public function ajouterEpisode(Episode $episode){
        $this->episodes[] = $episode;
        $nbEpisode++;
    }



    public function __set($attribut, $valeur){
        if (property_exists($this, $attribut)){
            if ($attribut == "titre" || $attribut == "genre" || $attribut == "public" || $attribut == "resume" || $attribut == "dateSortieFilm" || $attribut == "dateSortiePlateforme"){
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