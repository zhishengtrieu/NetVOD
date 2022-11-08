<?php
/**
 * Une serie est une liste d'episodes
 */
namespace netvod\video\serie;
use netvod\video\episode\Episode;
use netvod\exception\InvalidPropertyNameException;
use netvod\exception\NonEditablePropertyException;
use netvod\db\ConnectionFactory;
class Serie{

    private int $id;
    private string $titre;
    private array $genres;
    private array $public;
    private string $descriptif;
    private string $annee;
    private string $dateAjout;
    private int $nbEpisodes;
    private array $episodes;

    public function __construct(int $id, string $titre){
        $this->id = $id;
        $this->titre = $titre;
        $this->genres = array();
        $this->public = array();
        $this->descriptif = "";
        $this->annee = "";
        $this->dateAjout = 2000;
        $this->nbEpisodes = 0;
        $this->episodes = array();
    }

    public function ajouterEpisode(Episode $episode){
        $this->episodes[] = $episode;
        $this ->nbEpisodes++;
    }


    public function __set($attribut, $valeur){
        if (property_exists($this, $attribut)){
            if ($attribut == "titre" || $attribut == "genres" || $attribut == "public" || $attribut == "descriptif" || $attribut == "annee" || $attribut == "dateAjout"){
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
        $serie->descriptif = $res[0]['descriptif'];
        $serie->annee = $res[0]['annee'];
        $serie->dateAjout = $res[0]['date_ajout'];

        foreach ($res as $episode){
            $serie->ajouterEpisode(Episode::find($episode['id']));
        }
        return $serie;
    }


}
?>