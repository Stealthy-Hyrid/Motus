<?php

require_once './PHP/game_data/data.php';


if (isset($_COOKIE["used_word"], $_COOKIE["current_list"])) {

    if (isset($_COOKIE["api_word"])) {
        $api_word = $_COOKIE["api_word"];
        unset($_COOKIE["api_word"]);
        setcookie('api_word', '', time() - 3600, '/');
    } else {
        $api_word = null;
    }

    $current_list = $_COOKIE["current_list"];
    unset($_COOKIE["current_list"]);
    setcookie('current_list', '', time() - 3600, '/');

    $used_word = $_COOKIE["used_word"];
    unset($_COOKIE["used_word"]);
    setcookie('used_word', '', time() - 3600, '/');

    $dataModel = new Data();
    $dataModel->getConnexion(); // Assurez-vous que la méthode getConnexion() se connecte à la base de données
    $dataModel->updateData($used_word, $current_list, $api_word, $id);


} else {
    $current_list = null;
    $used_word = null;
}


if (isset($_COOKIE["score"])) {

    $score = $_COOKIE["score"];
    unset($_COOKIE["score"]);
    setcookie('score', '', time() - 3600, '/');

    $dataModel = new Data();
    $dataModel->getConnexion(); // Assurez-vous que la méthode getConnexion() se connecte à la base de données
    $dataModel->updateScore($score, $id);


}