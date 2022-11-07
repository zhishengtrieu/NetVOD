<?php
declare(strict_types=1);
namespace netvod\episode;
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


}
?>