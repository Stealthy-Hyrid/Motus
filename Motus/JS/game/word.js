import mots from './mots.json' with {type:'json'};
import { setSession, setCookie, eraseCookie, getClass, randomizeWord, saveUsedWord } from '../global/functions.js';
import { current, used} from '../global/variables.js';

// On récupère les mots via la liste fournie et l'assigne à une liste de mots à utiliser
for (let i = 0; i < mots.length; i++) {
        current.clean_list.push(mots[i].mot);
    }

// On assigne la liste de mot à utiliser à la liste actuelle si on créer un nouveau compte, sinon assigne la liste actuelle à la liste sauvegardée dans la base de données
if ((db_current_list[0].length == 0 || db_current_list == null) && db_used_word[0].length == 0){
    
    current.list = current.clean_list;
   
      
} else {
    current.list = db_current_list;
    
}

// On génère un mot via la liste ou une requête API
export function generateWord() {

// On génère un mot aléatoire via la liste, ou via une requete API si la liste est vide puis actualise la liste
randomizeWord(current.list);

if(current.word != null) {
    
   
    
    // On sauvegarde la longueur du mot dans un cookie afin d'y accéder via php
    eraseCookie(["length"]);
    setCookie("length",current.word.length.toString(),7);
}
}

// On récupère le mot et affiche la première lettre
export function retrieveWord() {

if(current.word != null) {

    getClass("first_letter")[0].innerHTML = current.word.charAt(0).toUpperCase();
}

}
