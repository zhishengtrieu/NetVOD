<?php
declare(strict_types=1);
namespace netvod\video\tris;

class TriMoyennePlusPetite extends Tri{
    public function __construct(){
        $this->query = "SELECT serie.id, AVG(note) AS moyenne_note FROM serie
                            LEFT JOIN commentaire ON serie.id = commentaire.serie_id
                            GROUP BY serie.id
                            ORDER BY moyenne_note ASC";
    }
}