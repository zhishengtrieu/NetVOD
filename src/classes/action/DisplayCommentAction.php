<?php
declare(strict_types=1);
namespace netvod\action;

class DisplayCommentAction extends Action{
    public function execute(): string {
        $html = "";
        if ($this->http_method == 'GET') {
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                $sql = "Select AVG(note) from commentaire
                        inner join serie on commentaire.serie_id = serie.id
                        where serie_id = $id";
                ConnectionFactory::makeConnection();
                $stmt = ConnectionFactory::$db->prepare($sql);
                $stmt->execute();
                $res = $stmt->fetch(\PDO::FETCH_ASSOC);
                foreach ($res as $commentaire) {
                    $html .= "Commentaire : $commentaire";
                }
            }
        }
        return $html;
    }
}