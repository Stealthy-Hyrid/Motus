import { current, used, inputs, points } from "./variables.js";
import { setGame } from "../game/launch.js";
import { checkSolution } from "../game/trial.js";


///// Function incondionnellement réutilisable

// Récupérer un élément via son id
export function getId(id) {
  return document.getElementById(id);
}

// Récupérer un élément via sa classe
export function getClass(className) {
  return document.getElementsByClassName(className);
}

// Modifier le background d'un element
export function setBackground(target, color) {
  return (target.style.background = color);
}

export function setText(target, text) {
  target.textContent = text;
}

// Récupérer une valeur dans la session
export function getSession(key) {
  return sessionStorage.getItem(key);
}

// Sauvegarder une valeur dans la session
export function setSession(key, value) {
  return sessionStorage.setItem(key, value);
}

// Suppression d'une valeur dans la session
export function clearSession(array) {

  array.forEach((key) => sessionStorage.removeItem(key))
  return 
}

// Générer un cookie
export function setCookie(target, value, days) {
  let expires = "";
  if (days) {
    let date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = target + "=" + (value || "") + expires + "; path=/";
}

// Suppression du cookie
export function eraseCookie(array) {
  array.forEach((key) => document.cookie = key + "=; Path=/; Expires=Thu, 01 Jan 2025 00:00:01 GMT;");
}

export function getCookie(target) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${target}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

// Ajout de classe
export function addClass(target, value) {
  return target.classList.add(value);
}

// Suppression de classe
export function removeClass(target, value) {
  return target.classList.remove(value);
}

// Vérifier si une cible possède une classe
export function checkClass(target, value) {
  return target.classList.contains(value);
}

// Afficher l'élément
export function show(target) {
  return target.classList.remove("d-none");
}

// Cacher l'élément
export function hide(target) {
  return target.classList.add("d-none");
}

// Alterner l'affichage de deux éléments
export function switchDisplay(target1, target2) {
  show(target1);
  hide(target2);
}


///// Function réutilisable pour une utilisation spécifique

// Récupération d'un mot aléatoire via la liste données, ou via une requête API lorsque la liste est épuisée
export function randomizeWord(list) {
  
    
  if(list.length > 0 && list[0].length > 0) {
    
    // Mot aléatoire
    let tempNum = Math.floor(Math.random() * list.length);
    let tempWord = list[tempNum];
    current.word = tempWord;

} else {

    // Mot aléatoire via une requête API
    if(!current.api_link) {
      $('#result_container').modal('hide');
      $('#difficulty_setting').modal('show');
      }
        current.word = current.api_word;


}
}

// Longueur aléatoire du nombre de lettre en fonction du niveau choisi
export function randomizeLength(value){

  let tempNum = Math.floor(Math.random() * 3);
  let result = value - tempNum 
  return result

}

// Recherche de mot via une requête API
export function searchApi(value) {
  
  let link = `https://trouve-mot.fr/api/size/${value}/1`;

  fetch(link)
  .then((response) => response.json())
  .then((words) => {

    current.api_word = words[0].name;
  });
}

// Mise à jour de la requete API via la difficulté choisi
export function updateApi(value){

  // Actualise les données
  current.api_link = `https://trouve-mot.fr/api/size/${value}/1`;
  setSession("api_link",current.api_link);

  // Actualise le niveau
  setSession("difficulty_level", value)

  // Ajuste le niveau (mot de lettre x à y)
  let max_length = randomizeLength(value);
  let link = `https://trouve-mot.fr/api/size/${max_length}/1`

  // Requête API
  fetch(link)
  .then((response) => response.json())
  .then((words) => current.api_word = words[0].name);

  // On relance le jeu
  setTimeout(() => {setGame();}, 300);

}

// Autotab à l'ajout, la suppression et validation via la touche Entré lorsque tout les inputs sont remplis
export function autoTab() {
  
  for (let i = 0; i < inputs.list.length; i++) {
    
    inputs.list[i].addEventListener("keyup", (event) => {
      let key = event.keyCode || event.charCode;
      
      // Autotab à l'ajout 
      if (key != 8 && inputs.list[i + 1] && inputs.list[i].value != "") {
        if (inputs.list[i + 1].disabled) {
          for (let input of inputs.list) {
            if (input.value == "") {
              input.focus();
              break;
            }
          }
        } else {
          inputs.list[i + 1].focus();
        }
      }

      // Vérifier les réponses avec Entrée
      if(key == 13 && inputs.list[i].value != "") {
        checkSolution();
    }
    });

    inputs.list[i].addEventListener("keydown", (event) => {
      let key = event.keyCode || event.charCode;
      
      // Autotab à la suppression
      if (key == 8 && inputs.list[i - 1] && inputs.list[i].value == "") {
        if (!inputs.list[i - 1].disabled) {
          inputs.list[i - 1].focus();
        } else {
          
        }
      }
    });
  }
}


// Sauvegarde de la liste de mot déjà utilisé
export function saveUsedWord() {
  if(current.word) {

    if(getSession("used_word")) {
      used.word = JSON.parse(getSession("used_word"));
    }

    if(!used.word.includes(current.word)) {

      used.word.push(current.word)
    }
    
    let tempArr = JSON.stringify(used.word);
    setSession("used_word", tempArr);
  }
}



// On actualise la liste de mot à utiliser dans la base de données
export function updateList(list) {
    
  list.splice(list.indexOf(current.word), 1);
  let tempList = list;
  setCookie("current_list", JSON.stringify(tempList), 7);
  
  }

  export function updateScore() {

    if(current.score == "") {
      current.score = 0
    }

    current.score = parseInt(current.score) + points.gain;
  
  }

// On actualise les données de jeu dans la base de données afin de ne pas réutiliser les même mots
export function updateDatabase() {
  setCookie("score", current.score, 7);
  setCookie("api_word", current.api_word, 7);
  setCookie("used_word", JSON.stringify(used.word), 7);
}

/// Test

export function replaceStrAtIndex( target, index, value ){
  let modifiedStr = [...target];
  modifiedStr[index] = value;
  return modifiedStr.join('')
}


export function counting(target, array) {
  target.forEach((letter) => {
    array[letter] = (array[letter] || 0) + 1;
  });
}