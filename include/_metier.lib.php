<?php

/*
 * PHP - Bibliothèques de fonctions
 * Fonctions métier
 */
include('./modele/App/Utilities.class.php');

/**
 * vérifie la validité du code d'un rayon (1 lettre en majuscules et un chiffre)
 * 
 * @param $valeur : une chaîne de caractère contenant le code du rayon
 * @return un booléen qui indique si le rayon est valide
*/
function rayonValide($valeur) {
    return preg_match("/^[A-Z][0-9]$/", $valeur) == 1;
}

/**
 * vérifie si la couverture d'un ouvrage existe dans le dossier
 * 
 * @param $id : l'id de l'ouvrage dont on recherche la couverture
 * @return un booléen qui indique si le fichier existe
*/
function couvertureExiste($id) {
    return file_exists(PATH_TO_IMG.$id.'.jpg');
}

/**
 * retourne le chemin d'accès vers l'image de la couverture d'un ouvrage
 * 
 * @param $id : l'id de l'ouvrage dont on recherche la couverture
 * @param $alt : l'attribut alt à indiquer sur l'image
 * @return une chaîne de caractères contenant une balise <img>
*/
function couvertureOuvrage($id, $alt) {
    $img = '<img src="';
    if (couvertureExiste($id)) {
        $img .= PATH_TO_IMG.$id.'.jpg" alt="'.$alt.'"';
    }
    else {
        $img .= PATH_TO_IMG.DEFAULT_IMG.'" alt="Image indisponible"';
    }
    $img .= ' />';
    return $img;
}

/**
 * Affiche une liste à partir d'un tableau unidimensionel
 * @param type $tab
 * @param type $name
 * @param type $select
 * @param type $class
 */
function afficherListe($tab,$name,$select,$class)
{
    if(empty($select))
    {
        $select = Utilities::firstOccur($tab,1);
    }
    echo '<select name="'.$name.'" class="'.$class.'" >';
        foreach($tab as $key=>$values) 
        {
            if($key == $select)
            {
                echo '<option selected value="'.$key.'">'.$values.'</option>';   
            }
            else{
                echo '<option value="'.$key.'">'.$values.'</option>';   
            }
        }
    echo('</select>');
}