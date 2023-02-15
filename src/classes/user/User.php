<?php
declare(strict_types=1);
namespace netvod\user;
use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use netvod\video\serie\Serie;
use netvod\video\episode\Episode;
use \PDO;
/**
 * un utilisateur possède plusieurs listes :
 * - une liste de videos preferees,
 * - une liste de videos deja visionnes,
 * - une liste de videos en cours : films ou docus non visionnes en intégralite, series non completees.
 */
class User{
    const ADMIN_USER = 100; 
    const NORMAL_USER = 1;
    const NO_USER = 0;
    private string $email;
    private string $nom;
    private string $prenom;
    private string $password;
    private array $VideosPreferees;
    private array $VideosVisionnees;
    private array $VideosEnCours;
    private int $role;
    private int $idGenre; 

    /**
     * Constructeur de la classe User
     */
    public function __construct(string $email, string $password, int $role){
        $this->email = $email;
        $this->nom = "";
        $this->prenom = "";
        $this->password = $password;
        $this->role = $role;
        $this->VideosPreferees = array();
        $this->VideosVisionnees = array();
        //la liste va associer la serie en cours a l'episode courant
        $this->VideosEnCours = array();
        $this->update();
        $this->idGenre = 1;
    }

    /**
     * Getter de la classe user
     */
    public function __get($attribut){
        if (property_exists($this, $attribut)){
            return $this->$attribut;
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }

    public function __set($attribut, $valeur){
        if (property_exists($this, $attribut)){
            $this->$attribut = $valeur;
        }else{
            throw new InvalidPropertyNameException($attribut);
        }
    }

    /**
     * 6. Ajout d’une série dans la liste de préférence d’un utilisateur
     * Lorsqu’une série est affichée, possibilité de l’ajouter à la liste de préférence 
     * de l’utilisateur au travers d’un bouton « ajouter à mes préférences ».
     * 
     */
    public function setSeriePreferee(Serie $serie){
        ConnectionFactory::makeConnection();
        if (!$this->favoris($serie->id)){
            $this->VideosPreferees[] = $serie;
            $sql = "INSERT INTO serie_favoris VALUES ('$this->email', $serie->id)";
            $stmt = ConnectionFactory::$db->prepare($sql);
            $stmt->execute();
        }else{
            $key = array_search($serie, $this->VideosPreferees);
            unset($this->VideosPreferees[$key]);
            $sql = "DELETE from serie_favoris where email = '$this->email' and serie_id = $serie->id";
            $stmt = ConnectionFactory::$db->prepare($sql);
            $stmt->execute();
        }
    }

    /**
     * Methode qui permet de savoir si une serie est dans la liste des favoris de l'utilisateur
     * @param int $id
     * @return bool
     */
    public function favoris(int $id) : bool{
        $serie = Serie::find($id);
        return in_array($serie, $this->VideosPreferees);
    }

    /**
     * Methode qui permet de savoir si une serie est dans la liste des videos en cours de visionnage de l'utilisateur
     * @param Serie $serie
     * @return void
     */
    public function addSerieEnCours(Serie $serie, Episode $episode){
        ConnectionFactory::makeConnection();
        //une video en cours est une serie non visionnee
        if (!in_array($serie, $this->VideosVisionnees)){
            //on regarde si la serie est deja une cle de la liste
            if (!array_key_exists($serie->id, $this->VideosEnCours)){
                $this->VideosEnCours[$serie->id] = $episode;
                $sql = "INSERT INTO serie_en_cours VALUES ('$this->email', $serie->id, $episode->id)";
                $stmt = ConnectionFactory::$db->prepare($sql);
                $stmt->execute();
            }else{
                //on regarde si l'episode courant est plus recent que celui en cours
                if ($this->VideosEnCours[$serie->id]->numero < $episode->numero){
                    $this->VideosEnCours[$serie->id] = $episode;
                    $sql = "UPDATE serie_en_cours SET episode_id = $episode->id WHERE email = '$this->email' AND serie_id = $serie->id";
                    $stmt = ConnectionFactory::$db->prepare($sql);
                    $stmt->execute();
                }
            }
        }
    }

    public function removeSerieEnCours(Serie $serie){
        ConnectionFactory::makeConnection();
        if (array_key_exists($serie->id, $this->VideosEnCours)){
            unset($this->VideosEnCours[$serie->id]);
            $sql = "DELETE from serie_en_cours where email = '$this->email' and serie_id = $serie->id";
            $stmt = ConnectionFactory::$db->prepare($sql);
            $stmt->execute();
        }
    }

    public function addSerieVisionnee(Serie $serie){
        ConnectionFactory::makeConnection();
        if (!in_array($serie, $this->VideosVisionnees)){
            $this->VideosVisionnees[] = $serie;
            $sql = "INSERT INTO serie_visionnees VALUES ('$this->email', $serie->id)";
            $stmt = ConnectionFactory::$db->prepare($sql);
            $stmt->execute();
        }
    }
    
    /**
     * methode update pour mettre a jour les listes de user
     * en fonction de la base de donnees
     */
    public function update(): void{
        ConnectionFactory::makeConnection();
        //on recupere les series preferees
        $sql = "SELECT * FROM user 
        inner join serie_favoris on user.email = serie_favoris.email
        WHERE user.email = '$this->email'";
        $query = ConnectionFactory::$db->prepare($sql);
        $query->execute();
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row){
            $serie = Serie::find((int) $row['serie_id']);
            $this->VideosPreferees[] = $serie;
        }

        //on recupere les series en cours
        $sql = "SELECT * FROM user
        inner join serie_en_cours on user.email = serie_en_cours.email
        WHERE user.email = '$this->email'";
        $query = ConnectionFactory::$db->prepare($sql);
        $query->execute();
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row){
            $serie = Serie::find((int) $row['serie_id']);
            $episode = Episode::find((int) $row['episode_id']);
            $this->VideosEnCours[$serie->id] = $episode;
        }

        //on recupere les series visionnees
        $sql = "SELECT * FROM user
        inner join serie_visionnees on user.email = serie_visionnees.email
        WHERE user.email = '$this->email'";
        $query = ConnectionFactory::$db->prepare($sql);
        $query->execute();
        foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row){
            $serie = Serie::find((int) $row['serie_id']);
            $this->VideosVisionnees[] = $serie;
        }
    }

}
?>
