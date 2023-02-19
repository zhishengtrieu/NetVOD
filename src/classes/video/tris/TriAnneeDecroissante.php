<?php
declare(strict_types=1);
namespace netvod\video\tris;

class TriAnneeDecroissante extends Tri{
    public function __construct(){
        $this->query = "SELECT id from serie order by annee desc";
    }
}