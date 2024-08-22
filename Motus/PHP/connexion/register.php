<?php 

session_start();

include_once '../template/header.php';

if (isset($_SESSION['player_id'])) {
    header("Location: http://localhost/php/Motus/motus.php");
}

require_once './database.php';

// Inscription du nouveau joueur
class Player extends Model
{
    public function newPlayer($nickname, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO player (nickname, email, password) VALUES (?,?, ?)";
        $requete = $this->connexion->prepare($sql);
        $requete->execute([$nickname, $email, $hashedPassword]);
        return $this->connexion->lastInsertId();
    }

    public function newPlayerData($id)
    {
        $sql = "INSERT INTO game_data (id) VALUES (?)";
        $requete = $this->connexion->prepare($sql);
        $requete->execute([$id]);
        return $this->connexion->lastInsertId();
    }

    public function getPlayerByEmail($email) {
        $sql = "SELECT * FROM player WHERE email = ?";
        $requete = $this->connexion->prepare($sql);
        $requete->bindValue(1, $email, PDO::PARAM_STR);
        $requete->execute([$email]);
        return $requete->fetch(PDO::FETCH_OBJ);
    }

    // Méthode pour récupérer un utilisateur par son pseudo
    public function getPlayerByNickname($nickname) {
        $sql = "SELECT * FROM player WHERE nickname = ?";
        $requete = $this->connexion->prepare($sql);
        $requete->bindValue(1, $nickname, PDO::PARAM_STR);
        $requete->execute([$nickname]);
        return $requete->fetch(PDO::FETCH_OBJ);
    }


}

/// Validation d'inscription
function validateForm($formData)
{
    $errors = [];

    // Validation et échappement des données utilisateur pour prévenir les attaques XSS
    $nickname = htmlspecialchars(trim($formData['nickname']));
    $email = htmlspecialchars(trim($formData['email']));
    $password = trim($formData['password']);

    if (empty($nickname)) {
        $errors['nickname'] = 'Le champ pseudo est requis.';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Une adresse email valide est requise.';
    }

    if (empty($password)) {
        $errors['password'] = 'Le champ mot de passe est requis.';
    }

    return ['nickname' => $nickname, 'email' => $email, 'password' => $password, 'errors' => $errors];
}


// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Valider les données du formulaire
    $formData = validateForm($_POST);

    // On vérifie que l'email ou le pseudo n'ont pas déjà été enregistré
    $check_db = new Player;
    $check_db->getConnexion();
    if ($check_db->getPlayerByEmail($_POST["email"]) == false && $check_db->getPlayerByNickname($_POST["nickname"]) == false ) {
   
    
    // S'il n'y a pas d'erreurs de validation, enregistrer les données dans la base de données
    if (empty($formData['errors'])) {
        $playerModel = new Player();
        $playerModel->getConnexion(); // Assurez-vous que la méthode getConnexion() se connecte à la base de données
        $newPlayerId = $playerModel->newPlayer($formData['nickname'], $formData['email'], $formData['password']);
        $playerModel->newPlayerData($newPlayerId);
        
        // Stocker l'ID du joueur dans la session
        $_SESSION['player_id'] = $newPlayerId;
        $_SESSION['nickname'] = $formData['nickname'];
        $_SESSION['email'] = $formData['email'];
        
        // Redirection vers le jeu
    
        header("Location: http://localhost/php/Motus/motus.php");
        exit();
    }
    } else {
        $_SESSION['error'] = "Le pseudo ou l'adresse email a déjà été enregistré(e)";
    }
}

?>

<div class="formulaire p-5 ">

    <form class="mx-auto text-center col-12 fs-6" method="post">
        <div class="mb-4 form-group">
            <label for="nickname" class="mb-1 fw-bold ">Pseudo</label><br>
            <input type="text" class="form-control mb-1" name="nickname" id="nickname" required>
            <?php if (isset($formData['errors']['nickname'])) { ?>
                <span class="text-warning"><?php echo $formData['errors']['nickname']; ?></span>
            <?php } ?>
        </div>
        
        <div class="mb-4 form-group">
            <label for="email" class="mb-1 fw-bold ">Email</label><br>
            <input type="email" class="form-control mb-1" name="email" id="email" required>
            <?php if (isset($formData['errors']['email'])) { ?>
                <span class="text-warning"><?php echo $formData['errors']['email']; ?></span>
            <?php } ?>
        </div>
        <div class="mb-4 form-group">
            <label for="password" class="mb-1 fw-bold ">Mot de passe</label><br>
            <input type="password" class="form-control mb-1" name="password" id="password" required>
            <?php if (isset($formData['errors']['password'])) { ?>
                <span class="text-warning"><?php echo $formData['errors']['password']; ?></span>
            <?php } ?>
        </div>
        <?php if (isset($_SESSION['error'])) { ?>
                <div class="mb-2"><span class="text-warning"><?php echo $_SESSION['error'] ?></span></div>
            <?php } ?>
        <div class="mb-4 form-group">
            <button type="submit" class="form-control btn my-3 login">Inscription</button>
        </div>
    </form>
   
    <div class="mt-4"><p>Vous avez déjà un compte ? <a class="fw-bold text-reset" href="http://localhost/php/Motus/PHP/connexion/login.php">Connectez vous</a></p></div>
</div>