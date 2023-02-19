<?php
declare(strict_types=1);
namespace netvod\video\tris;

class TriDateAjoutDecroissante extends Tri{
    public function __construct(){
        $this->query = "SELECT id from serie order by date_ajout desc";
    }
}