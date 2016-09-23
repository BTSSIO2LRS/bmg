<?php

/**
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe GenreDal
 * Utilise les services de la classe Application
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Genres : fabrique d'objets Genre
 *  ====================================================================
 */

// sollicite les méthodes de la classe GenreDal
require_once ('./modele/Dal/GenreDal.class.php');
// sollicite les services de la classe Application
require_once ('./modele/App/Application.class.php');
// sollicite la référence
require_once ('./modele/Reference/Genre.class.php');

class Genres {

    /**
     * Méthodes publiques
     */
    
    /**
     * récupère les genres pour les ouvrages
     * @param   $mode : 0 == tableau assoc, 1 == tableau d'objets
     * @return  un tableau de type $mode 
     */    
    public static function chargerLesGenres($mode) {
        $tab = GenreDal::loadGenres(1);
        if (Application::dataOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unGenre = new Genre(
                            $ligne->code_genre, 
                            $ligne->lib_genre 
                    );
                    array_push($res, $unGenre);
                }
                return $res;
            }
            else {
                return $tab;
            }
        }
        return NULL;
    }

    /**
     * vérifie si un genre existe
     * @param   $code : le code du genre à contrôler
     * @return  un booléen
     */    
    public static function genreExiste($code) {
        $values = GenreDal::loadGenreByID($code, 1);
        if (Application::dataOK($values)) {
            return 1;
        }
        return 0;
    }
        
    public static function ajouterGenre($valeurs) {
        $id = GenreDal::addGenre(
            $valeurs[0],
            $valeurs[1]
        );
        return self::chargerGenreParID($id);
    }

    public static function modifierGenre($genre) {
        return GenreDal::setGenre(
            $genre->getCode(), 
            $genre->getLibelle()
        );
    }    
    
    public static function supprimerGenre($code) {
        return GenreDal::delGenre($code);
    }    
    
    /**
     * récupère les caractéristiques d'un genre
     * @param   $id : le code du genre
     * @return  un objet de la classe Genre
     */
    public static function chargerGenreParId($id) {
        $values = GenreDal::loadGenreByID($id, 1);
        if (Application::dataOK($values)) {
            $libelle = $values[0]->lib_genre;
            return new Genre ($id, $libelle);
        }
        return NULL;
    }
    
    /**
     * récupère le nombre d'ouvrages pour un genre
     * @param   $code : le code du genre
     * @return  un entier
     */
    public static function nbOuvragesParGenre($code) {
        return GenreDal::countOuvragesGenre($code);
    }
        
}
