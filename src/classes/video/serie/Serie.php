<?php
declare(strict_types=1);
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
    private int $annee;
    private string $img;
    private string $dateAjout;
    private int $nbEpisodes;
    private array $episodes;

    /**
     * Constructeur de la classe Serie
     */
    public function __construct(int $id, string $titre){
        $this->id = $id;
        $this->titre = $titre;
        $this->genres = array();
        $this->public = array();
        $this->descriptif = "";
        $this->annee = 2000; //On met une annee par defaut
        $this->dateAjout = "";
        $this->nbEpisodes = 0;
        $this->episodes = array();
    }

    /**
     * Methode pour ajouter un episode a la serie
     */
    public function ajouterEpisode(Episode $episode) : void{
        $this->episodes[] = $episode;
        $this ->nbEpisodes++;
    }

    /**
     * Methode pour calculer la note moyenne de la serie
     */
    public function calculerMoyenneNote() :?string{
        $serie_id = $this -> id;
        $sql = "Select AVG(note) from commentaire
        inner join serie on commentaire.serie_id = serie.id
        where serie_id = $serie_id";
        ConnectionFactory::makeConnection();
        $stmt = ConnectionFactory::$db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $res['AVG(note)'];
    }

    public function afficherCommentaires(int $id) : array{
        $serie_id = $id;
        $sql = "Select commentaire from commentaire
        inner join serie on commentaire.serie_id = serie.id
        where serie_id = $serie_id";
        ConnectionFactory::makeConnection();
        $stmt = ConnectionFactory::$db->prepare($sql);
        $stmt -> execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $res;
    }


    /**
     * Setter de la classe Serie
     */
    public function __set($attribut, $valeur){
        if (property_exists($this, $attribut)){
            if ($attribut == "titre" || $attribut == "genres" || $attribut == "public" || $attribut == "descriptif" || $attribut == "img" || $attribut == "annee" || $attribut == "dateAjout"){
                $this->$attribut = $valeur;
            }else{
                throw new NonEditablePropertyException($attribut);
            }
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }

    /**
     * Getter de la classe Serie
     */
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
    public static function find(int $id) : Serie{
        $sql = "Select serie_id, serie.titre, descriptif,img, annee, date_ajout, episode.id from serie
        inner join episode on serie.id = episode.serie_id
        where serie_id = $id";
        ConnectionFactory::makeConnection();
        $stmt = ConnectionFactory::$db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        var_dump($res);
        $serie = new Serie((int) $res[0]['serie_id'], $res[0]['titre']);
        $serie->descriptif = $res[0]['descriptif'];
        $serie->annee = (int) $res[0]['annee'];
        $serie->dateAjout = $res[0]['date_ajout'];
        $serie->img = $res[0]['img'];

        foreach ($res as $episode){
            $serie->ajouterEpisode(Episode::find((int)$episode['id']));
        }

        //on recupere les genres et publics vises
        $sql = "Select libelle_genre from genre 
        inner join serie_genre on genre.id_genre = serie_genre.id_genre
        where id_serie = $id";
        $stmt = ConnectionFactory::$db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($res as $genre){
            $serie->genres[] = $genre['libelle_genre'];
        }

        $sql = "Select libelle_public from public
        inner join serie_public on public.id_public = serie_public.id_public
        where id_serie = $id";
        $stmt = ConnectionFactory::$db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($res as $public){
            $serie->public[] = $public['libelle_public'];
        }
        
        return $serie;
    }


}
?>