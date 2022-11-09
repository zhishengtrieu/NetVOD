<?php

namespace netvod\video\serie;

use netvod\exception\InvalidPropertyNameException;

class Commentaire{

    private string $commentaire;
    private int $note;

    public function __construct(string $comm, int $n){
        $this -> commentaire = $comm;
        $this -> note = $n;
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