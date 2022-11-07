<?php
declare(strict_types=1);
namespace netvod\action;
use netvod\auth\Auth;
use netvod\audio\lists\Playlist;
use netvod\user\User;
use netvod\render\AudioListRenderer;
use netvod\exception\AccessControlException;

class DisplayPlaylistAction extends Action{
    public function execute(): string{
        $res = "";
        if($this->http_method == 'GET'){
            if (isset($_GET['id'])){
                $id = (int) filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                if (isset($_SESSION['user'])){
                    $user = unserialize($_SESSION['user']);
                    try{
                        Auth::checkPlaylist($id);
                        $playlist = Playlist::find($id);
                        $res = (new AudioListRenderer($playlist))->render();
                    }catch(AccessControlException $e){
                        $res = $e->getMessage();
                    }
                    
                }
            }else{
                //doit donner index.php?action=displayplaylist&id=1
                $res = <<<HTML
                <form method="GET">
                    <input type="hidden" name="action" value="display-playlist">
                    <input type="number" name="id" placeholder="id">
                    <input type="submit" value="Afficher">
                </form>
                HTML;
            }
        }
        return $res;
    }
    
    
}


?>