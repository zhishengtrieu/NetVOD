<?php
declare(strict_types=1);
namespace netvod\video\tris;

class TriNbPetitEpisode extends Tri{
    public function __construct(){
        $this->query = "SELECT serie.id, count(episode.id) FROM serie 
                inner join episode on serie.id = episode.serie_id 
                group by serie.id order by count(episode.id) asc";
    }
}