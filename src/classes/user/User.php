<?php
declare(strict_types=1);
namespace netvod\user;
use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
use netvod\video\serie\Serie;
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

    public function __construct(string $email, string $password, int $role){
        $this->email = $email;
        $this->nom = "";
        $this->prenom = "";
        $this->password = $password;
        $this->VideosPreferees = [];
        $this->VideosVisionnees = [];
        $this->VideosEnCours = [];
        $this->role = $role;
    }

    public function __get($attribut){
        if (property_exists($this, $attribut)){
            return $this->$attribut;
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
        if (!$this->favoris($serie->id)){
            $this->VideosPreferees[] = $serie;
        }else{
            $key = array_search($serie, $this->VideosPreferees);
            unset($this->VideosPreferees[$key]);
        }
    }

    public function favoris(int $id) : bool{
        $serie = Serie::find($id);
        return in_array($serie, $this->VideosPreferees);
    }

    public function addSerieEnCours(Serie $serie){
        if (!in_array($serie, $this->VideosEnCours)){
            $this->VideosEnCours[] = $serie;
        }
    }

}
?>
