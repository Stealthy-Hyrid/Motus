import {getClass,setBackground,setText,switchDisplay, counting, autoTab, addClass, updateScore} from "../global/functions.js";
import { button, current, inputs, points, result, win, loss } from "../global/variables.js";

// Essaie en cours

// let counts = [];
let found_letter = [];

// On récupère le mot
if (current.word != "" || current.word != null || current.word != undefined) {
  // On récupere chaque inputs et les place dans un tableau

  for (let i = 0; i <= current.word.length - 2; i++) {
    inputs.list.push(getClass("letter_input_container")[i]);
  }

  // On insère le mot dans un tableau
  current.solution = current.word.split("");

  /* Test
  counting(current.solution, counts) */
 
  
  // On y insère la première lettre du mot
  inputs.entry.unshift(current.solution[0]);
  found_letter.unshift(current.solution[0]);

  // On insère les valeurs des inputs dans le tableau
  for (let i = 0; i < inputs.list.length; i++) {
    inputs.list[i].addEventListener("change", () => {
      inputs.entry[i + 1] = inputs.list[i].value.toLowerCase();
    });
  }


  // Autotab à l'ajout, à la suppression, vérification via la touche Entrée
  autoTab();

}
/// On réordonne les divs entre chaque essaies
function setNextTrial() {
  let nextRow = (value) => {
    $("#row_1").insertAfter(`#row_${value}`);
    setBackground(getClass(`row_${value}_letter`)[0], "#329932");
    current.trial += 1;
  };

  switch (current.trial) {
    case 0:
      nextRow(2);
      break;

    case 1:
      nextRow(3);
      break;
    case 2:
      nextRow(4);
      break;

    case 3:
      nextRow(5);
      break;

    case 4:
      nextRow(6);
      break;

    default:
  }

  // On remet le focus sur le prochain input vide
  for (let input of inputs.list) {
    if (input.value == "") {
      input.focus();
      break;
    }
  }
}

/// On compare les réponses données aux réponses attendues et on modifie l'affichage
function validateAnswer(target) {
  for (let i = 1; i < current.solution.length; i++) {
    
    // On identifie les cibles de changements
    let box;
    let input = getClass(`letter_input_container`)[i - 1];

    // On modidie la cible si on est au dernier essaie
    if (target == `row_${current.trial + 2}_letter`) {
      box = getClass(target)[i];
    } else {
      box = input;
    }

    // On vide la cible si on n'est pas au dernier essaie
    let deletePrevAnswer = () => {
      if (target == `row_${current.trial + 2}_letter`) {
        inputs.list[i - 1].value = "";
      }
    };
    


    // On compare les réponses données aux réponses attendues et modifie l'affichage en fonction
    if (current.solution[i] == inputs.entry[i]) {
      setBackground(box, "#329932");
      setBackground(input, "#329932");

      input.tabIndex = -1;
      input.disabled = "disabled";

      if(!found_letter.includes(inputs.entry[i])) {
        found_letter.push(inputs.entry[i]);
    }
    
    } else if (current.solution.includes(inputs.entry[i]) && !found_letter.includes(inputs.entry[i])) {
      setBackground(box, "#ffa500");
      deletePrevAnswer();
    } else {
      setBackground(box, "#ff0000");
      deletePrevAnswer();
    }
  }

  if (current.trial >= 5) {
    // On disable les inputs
  for (let input of getClass(`letter_input_container`)) {
    input.disabled = "disabled"
  }
  }
}

/// On affiche les essaies précédents
function insertPrevAnswer() {
  let prev_answer = [];

  for (let i = 0; i <= current.word.length - 1; i++) {
    prev_answer.push(getClass(`row_${current.trial + 1}_letter`)[i]);
  }

  for (let i = 0; i < prev_answer.length; i++) {
    if (inputs.entry[i] != undefined) {
      setText(prev_answer[i], inputs.entry[i].toUpperCase());
    }
  }
}

// On affiche le resultat
function reportResult(status) {
    
    // On modifie l'affichage de la grille de mot
    validateAnswer(`letter_input_container`);
    
    // On affiche le resultat
    setText(result.title, status.title);
    result.message.innerHTML = status.message
    result.icon.innerHTML = status.icon;
    
    // On affiche la bouton pour passer à la suite
    switchDisplay(button.start, button.check);
    
    // On affiche la fenêtre modale
    $('#result_container').modal('show')
}

/// Comparaison des réponses données, modification de l'affichage et affichage des essaies précédents, puis passage à l'essaie suivant ou annonce du résultat final
export function checkSolution() {
  if (current.solution.toString() !== inputs.entry.toString()) {
    if (current.trial < 5) {
      validateAnswer(`row_${current.trial + 2}_letter`);
      setNextTrial();
      insertPrevAnswer();
    } else {

      reportResult(loss);
      updateScore();
    }
  } else {

   reportResult(win);
   updateScore();

  }
}

