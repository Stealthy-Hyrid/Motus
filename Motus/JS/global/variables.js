import { getClass, getId, getSession } from "./functions.js";



/// Liste de boutons
export const button = {
  check: getId("game_check_btn"),
  start: getId("game_start_btn"),
  next: getId("game_next_btn"),
  reset: getId("game_reset_btn"),
  easy: getId("easy_btn"),
  medium: getId("medium_btn"),
  hard: getId("hard_btn"),
  difficulty: getId("game_difficulty_btn"),
  logout: getId("game_logout_btn"),
};

/// Liste de variables concernants les inputs
export const inputs = {
  list: [],
  entry: [],
}

/// Liste de variables pour le chargement actuel de la page
export const current = {
    word: db_used_word[db_used_word.length-1],
    solution: null,
    trial: 0,
    list: [],
    clean_list: [],
    api_word: db_api_word,
    api_link: getSession("api_link"), 
    score : db_score,
}

/// Liste de variables concernant les mots déjà utilisés
export const used = {
  word: [],
  list: localStorage.getItem('used_list'),
}

/// Liste de variables concernant le niveau de difficulté
export const difficulty = {
  setting : () => $('#difficulty_setting').modal('show'),
  level : getSession("difficulty_level"),
  label: getClass("difficulty_label"),

}

// Liste d'élément dans la fênetre modale de résultat
export const result = {
  title: getId("result_title"),
  message: getId("result_message"),
  icon : getId("result_icon"),
  box : getId("result_box"),
}

// Calcul des points
export const points = {
  get modifier() {
    if(difficulty.level != undefined) {
      switch (difficulty.level) {
        case "5":
          return  0.5;
        case "8":
          return 1;
        case "11":
          return 2;
        default:
      }
      } else {
        return 1;
      }
  },
  get gain() {
    return 100*points.modifier;
  },
}

/// Liste d'icones
export const icon = {
    win: `<img class="icon" src="./Assets/SVG/win.svg">`  ,
    loss: `<img class="icon" src="./Assets/SVG/loss.svg">` ,
}


////// Affichage de résultats
class Result {
  constructor(title, message, icon) {
    this.title = title;
    this.message = message;
    this.icon = icon;
   
  }
}

let test = points.gain;

// Défaite
export const loss = new Result(
  "Dommage !" ,
  `<p>La réponse était <b>${current.word}</b></p>`,

 icon.loss,
)

// Victoire
export const win = new Result(
  "Bien joué !" ,
  `<p>Vous avez gagné <b>${test}</b> points !</p>`,

  icon.win,
)