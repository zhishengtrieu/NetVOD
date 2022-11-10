<?php

declare(strict_types=1);
namespace netvod\video\tris;

// interface qui implementera chacun des tris
interface Tri{

    //la methode trier sera defini dans chanque classe implementant l'interface tri selon le tri voulu (via une requete sql)
    public function trier():string;

}