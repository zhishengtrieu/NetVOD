<?php
declare(strict_types=1);
namespace netvod\action;
use netvod\db\ConnectionFactory;

class DisplayCommentAction extends Action{
    public function execute(): string {
        $html = "";
        if ($this->http_method == 'POST') {
            if (isset($_SESSION['user'])) {
                $id = (int)$_POST['id'];
                $sql = "Select email, commentaire, note from commentaire
                        inner join serie on commentaire.serie_id = serie.id
                        where serie_id = $id";
                ConnectionFactory::makeConnection();
                $stmt = ConnectionFactory::$db->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() == 0){
                    $html .= "Pas de commentaire pour cette série";
                } else {
                    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
                        $html .= "Commentaire de " .$row['email']." : ".$row['commentaire'] . "<br>";
                        $html .= "Note : " .$row['note']."<br>";
                    }

                }
                $html .=<<<END
                   <form action='?action=display-liste-episodes&id=$id' method='GET' >
                    <input type='submit' value='Retour à l'accueil>
                  </form>
        END;
            }
        }

        return $html;
    }
}