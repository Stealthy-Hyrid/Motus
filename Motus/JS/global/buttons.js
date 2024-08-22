import { resetGame, setGame, nextGame } from "../game/launch.js";
import { checkSolution} from "../game/trial.js";
import { button} from "./variables.js";
import { updateApi, clearSession} from "./functions.js";

/// Commencer le jeu
($(button.start)).on("click", nextGame);

// Passer au prochain mot
($(button.next)).on("click",  nextGame);

/// Réinitialiser à 0
$(button.reset).on("click", resetGame);

/// Comparaison entre la réponse et le mot entré
$(button.check).on("click", checkSolution);



/// Paramètres de difficultés

// Facile
$(button.easy).on("click", () => {updateApi(5)});
// Moyen
$(button.medium).on("click", () => {updateApi(8)});
// Difficile
$(button.hard).on("click",  () => {updateApi(11)});



$(button.logout).on("click", () => {
    
        clearSession(["used_word", "api_word", "api_link", "difficulty_level"]);
        window.location.href='http://localhost/php/Motus/PHP/connexion/logout.php';
        
})