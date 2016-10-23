<?php

/**
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe AuteurDal
 * Utilise les services de la classe Application
 *
 * @package 	default
 * @author 	pv
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Genres : fabrique d'objets Genre
 *  ====================================================================
 */

// sollicite les méthodes de la classe GenreDal
require_once ('./modele/Dal/AuteurDal.class.php');
// sollicite les services de la classe Application
require_once ('./modele/App/Application.class.php');
// sollicite la référence
require_once ('./modele/Reference/Auteur.class.php');

class Auteurs {

    /**
     * Méthodes publiques
     */
    
    /**
     * récupère les auteurs pour les ouvrages
     * @param   $mode : 0 == tableau assoc, 1 == tableau d'objets
     * @return  un tableau de type $mode 
     */    
    public static function chargerLesAuteurs($mode) {
        $tab = AuteurDal::loadAuteurs(1);
        if (Application::dataOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unAuteur = new Auteur(
                            $ligne->id_auteur, 
                            $ligne->nom_auteur,
                            $ligne->prenom_auteur,
                            $ligne->alias,
                            $ligne->notes
                    );
                    array_push($res, $unAuteur);
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
     * vérifie si un auteur existe
     * @param   $id : l'id de l'auteur à contrôler
     * @return  un booléen
     */    
    public static function AuteurExiste($id) {
        $values = AuteurDal::loadAuteurByID($id, 1);
        if (Application::dataOK($values)) {
            return 1;
        }
        return 0;
    }
        
    public static function ajouterAuteur($valeurs) {
        $id = AuteurDal::addAuteur(
            $valeurs[0],
            $valeurs[1],
            $valeurs[2],
            $valeurs[3]
        );
        return self::chargerAuteurParID($id);
    }

    public static function modifierAuteur($auteur) {
        return AuteurDal::setAuteur(
            $auteur->getId(), 
            $auteur->getNom(),
            $auteur->getPrenom(), 
            $auteur->getAlias(),
            $auteur->getNotes()
        );
    }    
    
    public static function supprimerAuteur($id) {
        return AuteurDal::delAuteur($id);
    }    
    
    /**
     * récupère les caractéristiques d'un auteur
     * @param   $id : l'id de l'auteur
     * @return  un objet de la classe Auteur
     */
    public static function chargerAuteurParId($id) {
        $values = AuteurDal::loadAuteurByID($id, 1);
        if (Application::dataOK($values)) {
            $nom = $values[0]->nom_auteur;
            $prenom = $values[0]->prenom_auteur;
            $alias = $values[0]->alias;
            $notes = $values[0]->notes;
            return new Auteur ($id, $nom, $prenom, $alias, $notes );
        }
        return NULL;
    }
    
    /**
     * récupère le nombre d'ouvrages pour un auteur
     * @param   $id : l'id de l'auteur
     * @return  un entier
     */
    public static function nbOuvragesParAuteurs($id) {
        return AuteurDal::countOuvragesAuteur($id);
    }
        
    
    public static function listeAuteurEx($tabException){
        $tab = AuteurDal::loadAuteursOuvrage(0,$tabException);
        return $tab;
    }
}
