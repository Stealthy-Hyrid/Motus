<?php

class Data extends Model {

    public function updateData( $used_word, $current_list, $api_word, $id)
    {
        $sql = "UPDATE game_data SET  used_word = ?, current_list = ?, api_word = ? WHERE id = ?";
        $requete = $this->connexion->prepare($sql);
        $requete->execute([ $used_word, $current_list, $api_word, $id]);
        return $this->connexion;
    }

    public function getData($id) {
        $sql = "SELECT * FROM game_data WHERE id = ?";
        $requete = $this->connexion->prepare($sql);
        $requete->bindValue(1, $id, PDO::PARAM_INT);
        $requete->execute([$id]);
        return $requete->fetch(PDO::FETCH_OBJ);
    }

    public function updateScore( $score, $id)
    {
        $sql = "UPDATE player SET  score = ? WHERE id = ?";
        $requete = $this->connexion->prepare($sql);
        $requete->execute([ $score, $id]);
        return $this->connexion;
    }

    public function getScore($id) {
        $sql = "SELECT score FROM player WHERE id = ?";
        $requete = $this->connexion->prepare($sql);
        $requete->bindValue(1, $id, PDO::PARAM_INT);
        $requete->execute([$id]);
        return $requete->fetch(PDO::FETCH_OBJ);
    }

}
