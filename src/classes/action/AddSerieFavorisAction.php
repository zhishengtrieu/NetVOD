<?php
/**
 * Permet d'ajouter une serie a la liste 
 * des favoris de l'user
 */
namespace netvod\action;
use netvod\user\User;
use netvod\video\serie\Serie;

class AddSerieFavorisAction extends Action{
    
    public function execute(): string{
        $res = "";
        if($this->http_method == 'POST') {
            if (isset($_SESSION['user'])) {
                $user = unserialize($_SESSION['user']);
                $id = $_POST['id'];
                $serie = Serie::find($id);
                $user->addSeriePreferee($serie);
                $res = "Serie ajoutee aux favoris";
            }else{
                $res = "Vous devez etre connecte pour ajouter une serie aux favoris";
            }
        }else{
            $res = "Erreur";
        }
        return $res;
    }

}

?>