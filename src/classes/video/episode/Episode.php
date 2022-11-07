<?php
declare(strict_types=1);
namespace netvod\video\episode;
use netvod\exception\InvalidPropertyNameException;
use netvod\exception\NonEditablePropertyException;
use netvod\db\ConnectionFactory;

class Episode{
    private int $id;
    private int $numero;
    private string $titre;
    private string $resume;
    private int $duree;
    private string $path;
    private int $idSerie;

    public function __construct(int $id, int $numero, string $titre, string $resume, int $duree, string $path, int $serieId){
        $this->id = $id;
        $this->numero = $numero;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->duree = $duree;
        $this->path = $path;
        $this->idSerie = $serieId;
    }

    public function __set($attribut, $valeur){
        if (property_exists($this, $attribut)){
            if ($attribut == "id" || $attribut == "numero" || $attribut == "titre" || $attribut == "resume" || $attribut == "duree" || $attribut == "path"){
                $this->$attribut = $valeur;
            }else{
                throw new NonEditablePropertyException($attribut);
            }
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }

    public function __get($attribut){
        if (property_exists($this, $attribut)){
            return $this->$attribut;
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }

    public static function find(int $id){
        $sql = "Select * from episode 
        where id = $id";
        ConnectionFactory::makeConnection();
        $stmt = ConnectionFactory::$db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        $episode = new Episode((int) $row["id"], (int) $row["numero"], 
        $row["titre"], $row["resume"], (int) $row["duree"], $row["file"], (int) $row["serie_id"]);
        return $episode;
    }



}
?>