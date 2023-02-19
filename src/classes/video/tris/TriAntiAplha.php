<?php
declare(strict_types=1);
namespace netvod\video\tris;

class TriAntiAplha extends Tri{
    public function __construct(){
        $this->query = "SELECT id from serie order by titre desc";
    }
}