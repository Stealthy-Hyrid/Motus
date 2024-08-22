<?php 

require_once './PHP/game_data/data.php';

$id = $_SESSION['player_id'];
$dataModel = new Data();
$dataModel->getConnexion(); // Assurez-vous que la méthode getConnexion() se connecte à la base de données
$data = $dataModel->getData($id);
$data = json_decode(json_encode($data), true);

$score= $dataModel->getScore($id);
$score = json_decode(json_encode($score), true);

function strToArr($data, $value) {
    $data = $data[$value];
    $data = explode('"', $data);
    $tempArr = array();
    for ($i = 0; $i < count($data); $i++) {
        if ($i % 2 != 0) {
            array_push($tempArr, $data[$i]);
        }
    }
    return $tempArr;
};





?>



<script>

let db_used_word = [<?php echo '"'.implode('","',strToArr($data, 'used_word')).'"' ?>];
let db_current_list = [<?php echo '"'.implode('","',strToArr($data, 'current_list')).'"' ?>];
let db_api_word = "<?php echo $data['api_word'] ?>";
let db_score = "<?php echo $score['score'] ?>";




</script>