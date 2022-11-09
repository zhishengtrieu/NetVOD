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
    private string $email;
    private string $password;
    private array $VideosPreferees;
    private array $VideosVisionnees;
    private array $VideosEnCours;

    public function __construct(string $email, string $password){
        $this->email = $email;
        $this->password = $password;
        $this->VideosPreferees = [];
        $this->VideosVisionnees = [];
        $this->VideosEnCours = [];
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
    public function addSeriePreferee(Serie $serie){
        if (!in_array($serie, $this->VideosPreferees)){
            $this->VideosPreferees[] = $serie;
        }else{
            echo "Cette série est déjà dans votre liste de préférence";
        }
    }

    public function addSerieEnCours(Serie $serie){
        $this->VideosEnCours[] = $serie;
    }

}
?>
