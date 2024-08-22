<?php

class ScoreData extends Model {
    

    public function getAllScore() {
        $sql = "SELECT * FROM player";
        $requete = $this->connexion->prepare($sql);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_OBJ);
    }

}

$scoreModel = new ScoreData();
$scoreModel->getConnexion(); // Assurez-vous que la méthode getConnexion() se connecte à la base de données
$score = $scoreModel->getAllScore();
$score = json_decode(json_encode($score), true);


// On récupère les données et on les met dans un tableau
$score_array = array();
for ($i = 0; $i < count($score); $i++) {
    $score_array[$i] = array(
        'nickname' => $score[$i]['nickname'], 
        'score' => intval($score[$i]['score'])
    );
}


// On trie le tableau du score le plus haut, vers le score le plus bas
usort($score_array, function($a, $b) {
    return $b['score'] - $a['score'];
});

