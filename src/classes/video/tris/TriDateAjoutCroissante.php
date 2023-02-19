<?php
declare(strict_types=1);
namespace netvod\video\tris;

class TriDateAjoutCroissante extends Tri{
    public function __construct(){
        $this->query = "SELECT id from serie order by date_ajout asc";
    }
}