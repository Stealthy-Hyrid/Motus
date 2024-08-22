<!DOCTYPE html>
<html lang="fr">

<?php
session_start();

if (!isset($_SESSION['player_id'])) {
    header("Location: http://localhost/php/Motus/PHP/connexion/login.php");
} else {
    $id = $_SESSION['player_id'];
}

/// On envoie les informations de jeu dans la base de données
require_once './PHP/connexion/database.php';
require_once './PHP/game_data/updatePlayerData.php';
require_once './PHP/game_data/getPlayerData.php';

/// Si on est pas connecté on est redirigé


/// On sauvegarde la longueur du mot dans la session plutôt que dans un cookie pour éviter un disfonctionnement éventuel
if (isset($_COOKIE["length"])) {
    // On assigne la valeur à la session 
    $_SESSION["length"] = $_COOKIE["length"];
    $length = $_SESSION["length"];
    // On supprime le cookie
    unset($_COOKIE["length"]);
    setcookie('length', '', time() - 3600, '/');

} else if (isset($_SESSION["length"])) {
    // On assigne la valeur à la session 
    $length = $_SESSION["length"];
} else {
    $length = strToArr($data, 'used_word');
    $length = strlen(end($length));

}




?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./CSS/main.css" rel="stylesheet" type="text/css">
    <title>Motus</title>
</head>

<body>

    <!-- Container du jeu-->
    <div class="container">
        <div class="d-flex flex-column">

            <!-- Conteneur du jeu -->
            <div id="motus_game_container" class="mt-5 align-items-center justify-content-center">

                <div id="motus_grid_container">

                    <!-- Première ligne -->
                    <div id="row_1" class="trial">

                        <!-- Première lettres-->
                        <div id="first_letter_row1" class="letter_container first_letter"></div>

                        <!-- Input-->
                        <?php
                        for ($i = 0; $i < $length - 1; $i++) { ?>
                            <div class=" letter_container">
                                <input class="letter_input_container" type="text" maxlength="1"
                                    onkeydown=" return /[a-zâîïûôêéèë-]/i.test(event.key)">
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Deuxième ligne -->
                    <div id="row_2" class="trial">
                        <?php
                        for ($i = 0; $i < $length; $i++) { ?>
                            <div class="letter_container row_2_letter"></div>
                        <?php } ?>
                    </div>

                    <!-- Troisième ligne -->
                    <div id="row_3" class="trial">
                        <?php
                        for ($i = 0; $i < $length; $i++) { ?>
                            <div class="letter_container row_3_letter"></div>
                        <?php } ?>
                    </div>

                    <!-- Quatrième ligne -->
                    <div id="row_4" class="trial">
                        <?php
                        for ($i = 0; $i < $length; $i++) { ?>
                            <div class="letter_container row_4_letter"></div>
                        <?php } ?>
                    </div>

                    <!-- Cinquième ligne -->
                    <div id="row_5" class="trial">
                        <?php
                        for ($i = 0; $i < $length; $i++) { ?>
                            <div class="letter_container row_5_letter"></div>
                        <?php } ?>
                    </div>

                    <!-- Sixième ligne -->
                    <div id="row_6" class="trial">
                        <?php
                        for ($i = 0; $i < $length; $i++) { ?>
                            <div class="letter_container row_6_letter"></div>
                        <?php } ?>
                    </div>
                </div>

            </div>



            <!-- Carte de difficulté et de score-->
            <div class="mt-5 d-flex flex-row justify-content-center gap-3 ">
                <div class="col-3 justify-content-end">
                    <div class="card">

                        <div class="card-body text-center">
                            <h5 class="card-title mb-3 fs-5">Score actuel</h5>
                            <p class="card-text"><?php if (isset($score['score'])) {
                                if ($score['score'] != "") {
                                    echo $score['score'];
                                } else {
                                    echo 0;
                                }
                            } ?></p>
                            <button type="button" id="game_score_btn" class="btn btn-warning btn menu"
                                onclick="window.location.href='http://localhost/php/Motus/PHP/game_data/score.php'">Tableau des
                                scores</button>

                        </div>
                    </div>
                </div>

                <div class="col-3 justify-content-end">
                    <div class="card">

                        
                            
                            <div class="card-body d-flex flex-column align-items-center justify-content-center" id="game_buttons">
                                <div class="row">
                                    <button type="button" id="game_start_btn"class="btn btn btn-primary menu">Commencer</button>
                                    <button type="button" id="game_check_btn" class="btn btn btn-primary d-none menu">Vérifier la réponse</button>
                                </div>
                                    <hr>
                                <div class="row flex-row gap-3">
                    
                                    <button type="button" id="game_logout_btn" class="btn btn-warning col btn menu">Déconnexion</button>
                                    <button type="button" id="game_reset_btn" class="btn btn-warning col btn menu">Réinitialiser</button>
                                </div>
                            </div>

                        
                    </div>
                </div>


                <div class=" col-3 justify-content-start">
                    <div class="card p-1">

                        <div class="card-body text-center p-1 d-flex flex-column justify-content-center align-items-center">

                            <div class="card-text"">
                                <div class=" container d-flex flex-column align-items-center justify-content-center
                                mb-4 difficulty_label d-none">
                                <h5 class="mb-4 fs-5">Niveau : <span style="color: aquamarine;">Tutoriel</span></h5>
                                <div>
                                    <img class="icon_difficulty" src="./Assets/SVG/star.svg">
                                </div>
                            </div>
                            <div
                                class="container d-flex flex-column align-items-center justify-content-center mb-4 difficulty_label d-none">
                                <h5 class="mb-3 fs-5">Niveau : <span style="color: green;">Facile</span></h5>
                                <div>
                                    <?php
                                    for ($i = 0; $i < 2; $i++) { ?>
                                        <img class="icon_difficulty" src="./Assets/SVG/star.svg">
                                    <?php }
                                    ?>
                                </div>
                            </div>
                            <div
                                class="container d-flex flex-column align-items-center justify-content-center mb-4 difficulty_label d-none">
                                <h5 class="mb-3 fs-5">Niveau : <span style="color: yellow;">Moyen</span></h5>
                                <div>
                                    <?php
                                    for ($i = 0; $i < 3; $i++) { ?>
                                        <img class="icon_difficulty" src="./Assets/SVG/star.svg">
                                    <?php }
                                    ?>
                                </div>

                            </div>
                            <div
                                class="container d-flex flex-column align-items-center justify-content-center mb-4 difficulty_label d-none">
                                <h5 class="mb-3 fs-5 mt-2">Niveau : <span style="color: red;">Difficile</span></h5>
                                <div>
                                    <?php
                                    for ($i = 0; $i < 5; $i++) { ?>
                                        <img class="icon_difficulty" src="./Assets/SVG/star.svg">
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="game_difficulty_btn" class="btn btn btn-secondary menu d-none mb-2"
                            data-bs-toggle="modal" data-bs-target="#difficulty_setting">Changer la difficulté</button>

                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <?php
    require_once './PHP/popup/difficulty.php';
    require_once './PHP/popup/result.php';
    ?>



    <script src="./JS/game/load.js" type="module"></script>
    <script src="./JS/global/buttons.js" type="module"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</body>

</html>