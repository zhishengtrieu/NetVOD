<?php
namespace netvod\render;
class Header{
    public static function render(){
        echo '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>NetVOD</title>
            <link rel="stylesheet" href="src/css/style.css">
        </head>

        <body>
            <header>
                <h1>NetVOD</h1>
                <nav>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="index.php?action=add-user">Inscription</a></li>
                        <li><a href="index.php?action=signin">Se connecter</a></li>
                    </ul>
                </nav>
                <p>Le meilleur site de streaming de tout l\'iut</p>
            </header>
    ';
    }

}
?>