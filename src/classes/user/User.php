<?php
declare(strict_types=1);
namespace netvod\user;
use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;
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
        $this->VideosPreferees[] = $serie;
    }


     
    /*
    7. Page d’accueil d’un utilisateur : afficher ses séries préférées
    La page d’accueil d’un utilisateur affiche la liste des séries qu’il a ajouté dans ses préférences.
    La liste est cliquable : on peut afficher le détail d’une série à partir de cette liste.
    La page d’accueil est affichée automatiquement après le login, ou par click sur un bouton
    « retour à l’accueil » depuis toutes les pages.

    8. Lors du visionnage d’un épisode, ajouter automatiquement la série à la liste « en
    cours » de l’utilisateur
    Lorsqu’un épisode est visionné, la série contenant l’épisode est automatiquement ajoutée à la
    liste « en cours » de l’utilisateur ; Cette liste apparaît sur la page d’accueil de l’utilisateur, de
    façon similaire à la liste de préférence. 
    */
}
?>
