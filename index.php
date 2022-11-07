<?php
declare(strict_types=1);
session_start();
use netvod\auth\Auth;
use netvod\user\User;
use netvod\render\Header;

Header::render();

$action = isset($_GET['action']) ? $_GET['action'] : null;
$res="";
switch($action){
    case "add-user":
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $res= <<<END
            <form action="?action=add-user" method="POST">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="pwd" placeholder="password">
            <input type="number" name="age" placeholder="Age">
            <input type="text" name="genre" placeholder="Genre Musical">
            <input type="submit" value="Connexion">
            </form>
            END;
        }else{
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
            $genre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
            $res = "Email: $email, Age: $age ans, Genre musical: $genre";
            if (isset($_POST['email']) and isset($_POST['pwd'])){
                Auth::register($_POST['email'], $_POST['pwd']);
            }
        }
        break;
    case "signin" :
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (isset($_POST['email']) and isset($_POST['pwd'])) {
                $user = Auth::authenticate($_POST['email'], $_POST['pwd']);
                if ($user != null){
                    $playlists = $user->getPlaylists();
                    foreach ($playlists as $p){
                        $res .= (new AudioListRenderer($p))->render();
                    }
                }
            }
        }else{
            $res = <<<END
            <form action="?action=signin" method="post">
                <input type="text" name="email" placeholder="email">
                <input type="password" name="pwd" placeholder="password">
                <input type="submit" value="Se connecter">
            </form>
            END;
        }
        break;
    case "display-playlist":
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            if (isset($_SESSION['user'])){
                $user = unserialize($_SESSION['user']);
                if (Auth::checkPlaylist($id)){
                    $playlist = Playlist::find($id);
                    $res = (new AudioListRenderer($playlist))->render();
                }
            }
        }
        break;
    default:
        $res = "Bienvenue !";
}

echo <<<END
    $res
</body>
</html>
END;
?>