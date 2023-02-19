<?php
declare(strict_types=1);
namespace netvod\video\tris;

class TriNbGrandEpisode extends Tri{
    public function __construct(){
        $this->query = "SELECT serie.id, count(episode.id) from serie 
                inner join episode on serie.id = episode.serie_id 
                group by serie.id,titre order by count(episode.id) desc";
    }
}