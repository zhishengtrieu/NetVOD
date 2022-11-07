<?php
declare(strict_types=1);
namespace netvod\episode;
use netvod\exception\InvalidPropertyNameException;
use netvod\exception\NonEditablePropertyException;

class Episode{
    private int  $id;
    private int  $numero;
    private string  $titre;
    private string  $resume;
    private int  $duree;
    private string $path;

    public function __construct(int $id, int $numero, string $titre, string $resume, int $duree, string $path){
        $this->id = $id;
        $this->numero = $numero;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->duree = $duree;
        $this->path = $path;
    }

    public function __set($attribut, $valeur){
        if (property_exists($this, $attribut)){
            if ($attribut == "id" || $attribut == "numero" || $attribut == "titre" || $attribut == "resume" || $attribut == "duree" || $attribut == "path"){
                $this->$attribut = $valeur;
            }else{
                throw new NonEditablePropertyException($attribut);
            }
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }



}
?>