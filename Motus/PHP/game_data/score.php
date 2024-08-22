<?php

require_once '../connexion/database.php';
require_once './scoreData.php';

$page = 0;

if (array_key_exists('classement', $_GET)) {
    $page = intval($_GET['classement']);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableaux des scores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../../CSS/score.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="container d-flex flex-column align-items-center justify-content-center">



        <!-- Tableau des score -->
        <div class="w-75 row">
            <table class="table table-striped-columns text-center">
                <thead>
                    <tr>
                        <th scope="col" class="w-50">Pseudo</th>
                        <th scope="col" class="w-50">Score</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    for ($i = $page; $i < count($score_array); $i++) {
                        echo "<tr><td>" . $score_array[$i]['nickname'] . "</td><td class='score'>" . $score_array[$i]['score'] . "</td></tr>";
                    }
                    ?>

                    <?php
                    if ($page != 0) {

                        for ($i = 0; $i < count($score_array); $i++) {
                            echo "<tr><td> ... </td><td> ... </td></tr>";
                        }
                    }
                    ?>

                    <?php
                    for ($i = 0; $i < 10 - count($score_array); $i++) {
                        echo "<tr><td> ... </td><td> ... </td></tr>";
                    }
                    ?>


                </tbody>
            </table>
        </div>



        <!-- Navigation du tableau -->
        <div class="row w-75 d-flex flex-row mb-4">

            <div class="col d-flex justify-content-center align-items-center"><button class="btn menu"
                    onclick="window.location.href='http://localhost/php/Motus/motus.php'">Chercher un pseudo</button>
            </div>
            <div class="col mt-1 d-flex justify-content-center align-items-center">
                <ul class="pagination pagination">
                    <li class='page-item'><a class='page-link ' href='http://localhost/php/Motus/PHP/game_data/score.php?classement=<?php if ($page != 0) {echo $page - 10;} else {echo 0;} ?>'>←Précédent</a></li>
                    <li class='page-item'><a class='page-link' href='http://localhost/php/Motus/PHP/game_data/score.php?classement=<?php echo $page + 10 ?>'>Suivant →</a>
                    </li>
                </ul>
            </div>
            <div class="col d-flex justify-content-center align-items-center"><button class="btn menu"
                    onclick="window.location.href='http://localhost/php/Motus/motus.php'">Retour au jeu</button></div>
        </div>

    </div>


    </div>
</body>

</html>

<?php


?>