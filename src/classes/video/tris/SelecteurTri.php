<?php
declare(strict_types=1);
namespace netvod\video\tris;

class SelecteurTri{

    //constantes correpondants chacune à un tri différent
    const TRI_ALPHA = 1;
    const TRI_ANTI_ALPHA = 2;
    const TRI_NB_GRAND_EPISODE = 3;
    const TRI_NB_PETIT_EPISODE = 4;
    const TRI_MOYENNE_NOTE_PLUS_GRANDE =5;
    const TRI_MOYENNE_NOTE_PLUS_PETITE =6;
    const TRI_DATE_AJOUT_CROISSANTE = 7;
    const TRI_DATE_AJOUT_DECROISSANTE = 8;
    const TRI_ANNEE_CROISSANTE =9;
    const TRI_ANNEE_DECROISSANTE = 10;

    //fonction permettant de choisir quelles est la sorte de tri que l'on veut appliquer
    public static function selectionnerTri(int $indice_selection) : ?Tri{
        // on fait un switch sur l'indice de la session qui est assimilé a une constante
        switch ($indice_selection){
            //pour chaque case correspondant a une sorte de tri
            case self::TRI_ALPHA:
                //on instancie la methode de tri correspondante
                $tri =new TriAlpha();
            break;
            case self::TRI_ANTI_ALPHA:
                $tri = new TriAntiAplha();
            break;
            case self::TRI_NB_GRAND_EPISODE:
                $tri = new TriNbGrandEpisode();
            break;
            case self::TRI_NB_PETIT_EPISODE:
                $tri = new TriNbPetitEpisode();
            break;
            case self::TRI_MOYENNE_NOTE_PLUS_GRANDE:
                $tri = new TriMoyennePlusGrande();
            break;
            case self::TRI_MOYENNE_NOTE_PLUS_PETITE:
                $tri = new TriMoyennePlusPetite();
            break;
            case self::TRI_DATE_AJOUT_CROISSANTE:
                $tri = new TriDateAjoutCroissante();
            break;
            case self::TRI_DATE_AJOUT_DECROISSANTE:
                $tri = new TriDateAjoutDecroissante();
            break;
            case self::TRI_ANNEE_CROISSANTE:
                $tri = new TriAnneeCroissante();
            break;
            case self::TRI_ANNEE_DECROISSANTE:
                $tri = new TriAnneeDecroissante();
            break;
            default:
                $tri = null;
        }
        return  $tri;
    }
}