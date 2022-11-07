<?php

class AddCommentAction extends Action{

    public function execute(): string{
        if($this->http_method == 'POST') {
            $res = "";
            if (isset($_POST['comment']) and isset($_POST['id'])){
                $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
                $res = "Commentaire: $comment <br> Id: $id";
            }
        }else{
            $res= <<<END
            <form action="?action=add-comment" method="POST">
                <input type="string" name="commentaire" placeholder="comment">
                <select name="nom">
                    <option value="1">1 etoile</option>
                    <option value="2">2 etoiles</option>
                    <option value="3">3 etoiles</option>
                    <option value="4">4 etoiles</option>
                    <option value="5">5 etoiles</option>
                </select>
                <input type="submit" value="Enregistrer le commentaire">
            </form>
            END;
        }
        return $res;
    }
}