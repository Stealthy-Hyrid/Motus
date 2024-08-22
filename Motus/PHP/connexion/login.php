<?php
// Démarrer la session
session_start();

include_once '../template/header.php';

if (isset($_SESSION['player_id'])) {
    header("Location: http://localhost/php/Motus/motus.php");
}

require_once './database.php';


class Player extends Model {
    // Méthode pour récupérer un utilisateur par son adresse e-mail
    
    public function getPlayerByEmail($email) {
        $sql = "SELECT * FROM player WHERE email = ?";
        $requete = $this->connexion->prepare($sql);
        $requete->bindValue(1, $email, PDO::PARAM_STR);
        $requete->execute([$email]);
        return $requete->fetch(PDO::FETCH_OBJ);
    }

    // Méthode pour récupérer un utilisateur par son nickname
    public function getPlayerByNickname($nickname) {
        $sql = "SELECT * FROM player WHERE nickname = ?";
        $requete = $this->connexion->prepare($sql);
        $requete->bindValue(1, $nickname, PDO::PARAM_STR);
        $requete->execute([$nickname]);
        return $requete->fetch(PDO::FETCH_OBJ);
    }
    // Vous pouvez ajouter d'autres méthodes liées aux clients ici selon vos besoins
}

function validateForm($formData) {
  $errors = [];

  // Validation et échappement des données utilisateur pour prévenir les attaques XSS
  $nickname = htmlspecialchars(trim($formData['nickname']));
  $password = trim($formData['password']);

  if (empty($nickname)) {
      $errors['nickname'] = 'Le champ email ou nickname est requis.';
  }

  if (empty($password)) {
      $errors['password'] = 'Le champ mot de passe est requis.';
  }

  // Initialisez $formData['errors'] avec un tableau vide
  $formData['errors'] = $errors;

  return ['nickname' => $nickname, 'password' => $password, 'errors' => $errors];
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valider les données du formulaire
    $formData = validateForm($_POST);

    // S'il n'y a pas d'erreurs de validation, vérifier les informations de connexion
    if (empty($formData['errors'])) {
        $playerModel = new Player();
        $playerModel->getConnexion();

        // Nettoyer et valider l'nickname (email ou nickname) avec FILTER_SANITIZE_EMAIL
        $cleanednickname = filter_var($formData['nickname'], FILTER_SANITIZE_EMAIL);

        // Rechercher l'utilisateur par nickname (email ou nickname) dans la base de données
        if (filter_var($cleanednickname, FILTER_VALIDATE_EMAIL)) {
            // Rechercher l'utilisateur par e-mail dans la base de données
            $user = $playerModel->getPlayerByEmail($cleanednickname);
        } else {
            // Rechercher l'utilisateur par nickname dans la base de données
            $user = $playerModel->getPlayerByNickname($cleanednickname);
        }

        // Vérifier si l'utilisateur a été trouvé dans la base de données
        if ($user) {
            // Vérifier si le mot de passe saisi correspond au mot de passe haché dans la base de données
            if (password_verify($formData['password'], $user->password)) {
                // Mot de passe correct

                $_SESSION['player_id'] = $user->id;
                $_SESSION['nickname'] = $user->nickname;
                $_SESSION['email'] = $user->email;
                // Rediriger l'utilisateur vers le dashboard ou toute autre page appropriée
                header("Location: http://localhost/php/Motus/motus.php");
                exit();
            } else {
                // Mot de passe incorrect
                $formData['errors']['password'] = 'Mot de passe incorrect';
            }
        } else {
            // Utilisateur non trouvé dans la base de données
            $formData['errors']['nickname'] = 'Pseudo ou email incorrect';
        }
    }
}
?>

        <div class="formulaire p-5 ">
            <form method="post" class="mx-auto text-center col-12 fs-6" action="">
                <div class="mb-4 form-group">
                    <label for="nickname"  class="mb-1 fw-bold  ">Pseudo / Email</label>
                    <input type="text" class="form-control <?php echo !empty($formData['errors']['nickname']) ? 'is-invalid' : ''; ?>" 
                    name="nickname" id="nickname" value="<?php echo isset($formData['nickname']) ? $formData['nickname'] : ''; ?>" required>
                    <?php if (!empty($formData['errors']['nickname'])) : ?>
                  <span class="text-warning">
                      <?php echo $formData['errors']['nickname']; ?>
                  </span>
              <?php endif; ?>
          </div>
          <div class="mb-4 form-group">
              <label for="password" class="mb-1 fw-bold ">Mot de passe</label>
              <input type="password" class="form-control <?php echo !empty($formData['errors']['password']) ? 'is-invalid' : ''; ?>" 
              name="password" id="password" required>
              <?php if (!empty($formData['errors']['password'])) : ?>
                  <span class="text-danger">
                      <?php echo $formData['errors']['password']; ?>
                  </span>
              <?php endif; ?>
          </div>
          <div class="mb-4 form-group">
              <button type="submit" class="form-control btn my-3 login">Connexion</button>
          </div>
            </form>
            <p>Vous n'avez pas de compte ? <a class="text-reset fw-bold" href="http://localhost/php/Motus/PHP/connexion/register.php">Inscrivez-vous</a></p>
        </div>
    
</body>
</html>