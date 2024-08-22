import { generateWord} from './word.js';
import { current, difficulty} from '../global/variables.js';
import { clearSession, updateDatabase, updateList, saveUsedWord, setCookie} from '../global/functions.js';



// Reset complet du jeu et de ses données
export function resetGame() {
  current.score = 0;
  setCookie("score", "0", 7);

    current.api_word = null;
    setCookie("api_word", current.api_word, 7);
    
    // Reset des données
    clearSession(["used_word", "api_word", "api_link", "difficulty_level"]);
    current.list = current.clean_list;
   
    setGame();
}

// Commencer le jeu
export function setGame() { 

// On génère un mot
generateWord();

// On sauvegarde le mot utilisé
saveUsedWord();

// On met à jour la liste de mot
updateList(current.list);

// On met à jour la base de données
updateDatabase();

// On rafraichit la page pour actualiser le jeu
window.location.reload(true);
  
      }


export function nextGame() {
  
  // Si on a atteint la liste de mots fournie, on force le choix d'un niveau de difficulté afin de relancer le jeu en faisant une requete API
  if(current.list.length == 1 && current.list[0].length == 0 && db_used_word.length > 0 && !current.api_link ) {
    difficulty.setting();
    $('#result_container').modal('hide')

  // Sinon on lance le jeu
  } else {
    setGame();

  }


  }
