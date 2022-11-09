<?php
/**
 * Permet d'ajouter une serie a la liste 
 * des favoris de l'user
 */
namespace netvod\action;
use netvod\user\User;
use netvod\video\serie\Serie;

class SetFavorisAction extends Action{
    
    public function execute(): string{
        $res = "";
        if($this->http_method == 'POST') {
            if (isset($_SESSION['user'])) {
                $user = unserialize($_SESSION['user']);
                $id = (int) filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
                $serie = Serie::find($id);
                $user->setSeriePreferee($serie);
                $_SESSION['user'] = serialize($user);
                if ($user->favoris($id)){
                    $res = "La serie a bien ete ajoutee a vos favoris";
                }else{
                    $res = "La serie a bien ete retiré de vos favoris";
                }
            }else{
                $res = "Vous devez etre connecte pour ajouter/retirer une serie aux favoris";
            }
        }else{
            $res = "Erreur";
        }
        return $res;
    }

}

?>