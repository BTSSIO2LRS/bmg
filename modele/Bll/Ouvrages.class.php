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
 *  Classe Ouvrages : fabrique d'objets Ouvrage
 *  ====================================================================
 */

// sollicite les méthodes de la classe OuvrageDal
require_once ('./modele/Dal/OuvrageDal.class.php');
// sollicite les services de la classe Application
require_once ('./modele/App/Application.class.php');
// sollicite la référence
require_once ('./modele/Reference/Ouvrage.class.php');

class Ouvrages {

    /**
     * Méthodes publiques
     */
    
    /**
     * récupère les ouvrages
     * @param   $mode : 0 == tableau assoc, 1 == tableau d'objets
     * @return  un tableau de type $mode 
     */    
    public static function chargerLesOuvrages($mode) {
        $tab = OuvrageDal::loadOuvrages(1);
        if (Application::dataOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unOuvrage = new Ouvrage(
                            $ligne->no_ouvrage, 
                            $ligne->titre,
                            $ligne->salle,
                            $ligne->rayon,
                            new Genre($ligne->code_genre,$ligne->lib_genre),
                            $ligne->acquisition
                    );
                    array_push($res, $unOuvrage);
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
     * vérifie si un ouvrage existe
     * @param   $id : l'id de l'ouvrage à contrôler
     * @return  un booléen
     */    
    public static function ouvrageExists($id) {
        $values = ouvrageDal::loadOuvrageByID($id, 1);
        if (Application::dataOK($values)) {
            return 1;
        }
        return 0;
    }
        
    
    public static function ajouterOuvrage($valeurs) {
        $id = OuvrageDal::addOuvrage(
                $valeurs[0],
                $valeurs[1],
                $valeurs[2],
                $valeurs[3],
                $valeurs[4],
                $valeurs[5]
            );
        $unOuvrage = self::chargerOuvrageParID($id);
        return $unOuvrage;
    }

    public static function modifierOuvrage($unOuvrage) {
        return OuvrageDal::setOuvrage(
            $unOuvrage->getNo(),
            $unOuvrage->getTitre(),
            $unOuvrage->getSalle(),
            $unOuvrage->getRayon(),
            $unOuvrage->getGenre()->getCode(),
            $unOuvrage->getDateAcqui()
        );
    }    
    
    public static function supprimerOuvrage($code) {
        return OuvrageDal::delOuvrage($code);
    }    
    
    /**
     * récupère les caractéristiques d'un genre
     * @param   $no : le numéro de l'ouvrage
     * @return  un objet de la classe Ouvrage
     */
    public static function chargerOuvrageParId($no) {
        $lOuvrage = OuvrageDal::loadOuvrageByID($no);
        $unOuvrage = new Ouvrage($lOuvrage[0]->no_ouvrage,
                                 $lOuvrage[0]->titre,
                                 $lOuvrage[0]->salle,
                                 $lOuvrage[0]->rayon,
                                 (new Genre($lOuvrage[0]->code_genre,$lOuvrage[0]->lib_genre)),
                                 $lOuvrage[0]->acquisition);
        return $unOuvrage;            
    }
    
    /**
     * récupère le nombre d'ouvrages pour un genre
     * @param   $code : le code du genre
     * @return  un entier
     */
    public static function nbOuvragesParGenre($code) {
        return GenreDal::countOuvragesGenre($code);
    }
    
    /**
     * ajouterAuteurOuvrage ajoute un auteur à l'ouvrage donné en paramétre
     * @param type $id_ouvrage l'id de l'ouvrage auquel on ajoute un auteur
     */
    public static function ajouterAuteurOuvrage($id_ouvrage,$id_auteur)
    {
        return OuvrageDal::addAuteurOuvrage($id_ouvrage,$id_auteur);
    }
        
}
