<?php
declare(strict_types=1);

namespace netvod\render;
class Header{
    public static function render(){
        if(isset($_SESSION['user'])){
            $profilAction =  "display-profil";
            $txt = "Profil"; 
        }else{
            $profilAction = "signin";
            $txt = "S'inscrire/Se connecter" ; 
        }
        echo '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>NetVOD</title>
            <link rel="stylesheet" href="src/css/style.css">
            <link rel="icon" type="image/png" href="img/icon.png" />
        </head>

        <body>
            <header>
                <h1><a href="index.php">NetVOD</a></h1>
                <nav>
                    <ul>
                        <li><a href="index.php?action=afficherCatalogue">Afficher le catalogue</a></li>
                        <li><a href="index.php?action='.$profilAction.'">'.$txt.'</a></li>
                    </ul>
                </nav>
            </header>';
    }

}
?>