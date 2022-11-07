<?php
/**
 * Une serie est une liste d'episodes
 */
namespace netvod\video\Serie;
use netvod\video\episode\Episode;
use netvod\exception\InvalidPropertyNameException;
use netvod\exception\NonEditablePropertyException;
use netvod\db\ConnectionFactory;
class Serie{

    private int $id;
    private string $titre;
    private string $genre;
    private string $public;
    private string $resume;
    private string $dateSortieFilm;
    private string $dateSortiePlateforme;
    private int $nbEpisode;
    private array $episodes;

    public function __construct(int $id, string $titre, string $genre=""){
        $this->id = $id;
        $this->titre = $titre;
        $this->genre = $genre;
        $this->nbEpisode = 0;
        $this->episodes = array();
    }

    public function ajouterEpisode(Episode $episode){
        $this->episodes[] = $episode;
        $this ->nbEpisode++;
    }


    public function __set($attribut, $valeur){
        if (property_exists($this, $attribut)){
            if ($attribut == "titre" || $attribut == "genre" || $attribut == "public" || $attribut == "resume" || $attribut == "dateSortieFilm" || $attribut == "dateSortiePlateforme"){
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

    /**
     * Permet de retrouver une serie a partir de son id et d'en retourner l'objet
     */
    public static function find(int $id){
        $sql = "Select serie_id, serie.titre, descriptif, annee, date_ajout, episode.id from serie
        inner join episode on serie.id = episode.serie_id
        where serie_id = $id"; 
        ConnectionFactory::makeConnection();
        $stmt = ConnectionFactory::$db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $serie = new Serie($res[0]['serie_id'], $res[0]['titre']);
        $serie->resume = $res[0]['descriptif'];
        $serie->dateSortieFilm = $res[0]['annee'];
        $serie->dateSortiePlateforme = $res[0]['date_ajout'];

        foreach ($res as $episode){
            $serie->ajouterEpisode(Episode::find($episode['id']));
        }
        return $serie;
    }


}
?>