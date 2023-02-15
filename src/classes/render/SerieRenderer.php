<?php
declare(strict_types=1);
namespace netvod\render;
use netvod\db\ConnectionFactory;
use netvod\video\serie\Serie;

class SerieRenderer implements Renderer{
    private Serie $serie;

    public function __construct(Serie $serie){
        $this->serie = $serie;
    }

    public function render(int $selector):string{
        $html = "";
        switch($selector){
            case Renderer::COMPACT:
                $html = $this->renderCompact();
                break;
            case Renderer::LONG:
                $html = $this->renderLong();
                break;
        }
        return $html;
    }

    //affichage en mode court
    private function renderCompact():string{
        //on cherche un serie par rapport a son id
        $serie = Serie::find($this->serie->id);
        // affichage du titre de la serie et son image
        $html = "
        <div class='serie'>
            <a href='?action=display-liste-episodes&id=$serie->id'>
                <h3>{$this->serie->titre}</h3>
                <img src='img/{$this->serie->img}' height='300' width='400'>
            </a>
        </div>
        ";
        return $html;
    }

    //affichage en mode long
    private function renderLong():string{
        //affichage du titre, du descriptif, de l'annee de sortie, de la date d'ajout, du nombre d'episode, et de la note moyenne
        $html = "<h1>{$this->serie->titre}</h1>
        <h4>{$this->serie->descriptif}</h4>";

        
        // on affiches les genres et les publics de la serie
        $html.= "
            <h4>Date de sortie : {$this->serie->annee}</h4>
            <h4>Date d'ajout : {$this->serie->dateAjout}</h4>
            <h4>Nombre d'épisodes : {$this->serie->nbEpisodes}</h4>
            <h4>Note moyenne : {$this->serie->calculerMoyenneNote()}</h4>
            <h4>Genres : " . implode(", ", $this->serie->genres) . "</h4>
            <h4>Public : " . implode(", ", $this->serie->public) . "</h4>
        ";

        //formualire du bouton pour afficher les commentaires de la serie
        $html.= <<<END
        <form action="?action=display-comment" method="POST">
            <input type="hidden" name="id" value="{$this->serie->id}">
            <input type ="submit" value="Voir les commentaires">
        </form>
        END;

        //on doit permettre a l'user d'ajouter ou retirer la serie a ses favoris
        $user = unserialize($_SESSION['user']);
        //on verifie si la serie est deja dans les favoris de l'user
        //si on oui le bouton dit qu'il le retirera des favoris sinon il indique qu'il l'ajoutera
        $action = $user->favoris($this->serie->id) ? "Retirer de" : "Ajouter à";
        //on donne le formulaire 
        $html.= <<<END
        <form action="?action=set-favoris" method="POST">
            <input type="hidden" name="id" value="{$this->serie->id}">
            <input type="submit" value="$action mes préférences">
        </form>
        END;
        // pour tout les episodes dans la liste d'episode de la serie
        foreach ($this->serie->episodes as $ep){
            //on affiche l'episode en mode court
            $renderer = new EpisodeRenderer($ep);
            $html .= $renderer->render(Renderer::COMPACT);
        }
        return $html;
    }
}
?>