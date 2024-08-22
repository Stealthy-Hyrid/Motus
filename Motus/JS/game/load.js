import { retrieveWord} from "./word.js";
import {getId,switchDisplay, setText, hide, searchApi,randomizeLength, addClass, show} from "../global/functions.js";
import { button, current, difficulty, used, inputs } from "../global/variables.js";
import { nextGame } from "./launch.js";



/// Popover
export const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
export const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))


/// Chargement du jeu
window.addEventListener("load", () => {

  // Force le choix de difficulté même au rafraichissement si on est arrivé à la fin de la liste de mot
  

  // Lance la requête API si la difficulté a été choisie
  if(difficulty.level){
    do {
      searchApi(randomizeLength(difficulty.level));
      
      // On relance la requête si le mot a déjà été vu auparavant
    } while (used.word.includes(current.api_word));


   show(button.difficulty);
    switch(difficulty.level) {
      case "5":
        show(difficulty.label[1]);
        break;

      case "8":
        show(difficulty.label[2]);
        break;

      case "11":
      show(difficulty.label[3]);
      break;
      default:
    }
  } else {
    show(difficulty.label[0]);
}


  // Lancement du jeu (temporaire)
  if (current.word == undefined || current.word == null || current.word == "") {
    hide(getId("motus_grid_container"));
  } else {
    switchDisplay(button.check, button.start);
    setText(button.start,"Passer au mot suivant")
  }


  
  // Récupération du mot pour l'affichage
  retrieveWord();

  // Affichage général
  addClass(getId("motus_game_container"),"load");
  
  inputs.list[0].focus();
});


window.addEventListener("beforeunload", () => {
 
if((current.list.length == 1 || current.list.length == 0) && current.list[0].length == 0) {
nextGame();

}
});



