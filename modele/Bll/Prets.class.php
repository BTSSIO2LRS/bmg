<?php

/**
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe PretDal
 * Utilise les services de la classe Application
 *
 * @package 	default
 * @author 	Baptiste et Alicia ,28/09/2016
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Pret : fabrique d'objets Pret
 *  ====================================================================
 */

// sollicite les méthodes de la classe PretDal
require_once ('./modele/Dal/PretDal.class.php');
// sollicite les services de la classe Application
require_once ('./modele/App/Application.class.php');
// sollicite la référence de la classe Pret
require_once ('./modele/Reference/Pret.class.php');

class Prets {

    /**
     * Méthodes publiques
     */
    
    /**
     * r�cup�re les prets
     * @param   $mode : 0 == tableau assoc, 1 == tableau d'objets
     * @return  un tableau de type $mode 
     */    
    public static function chargerLesPrets($mode) {
        $tab = PretDal::loadGenericPret(0,array(PRETS_EN_COURS));
        if (Application::dataOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unPret = new Pret(
                            $ligne->id_pret, 
                            $ligne->no_client, 
                            $ligne->no_ouvrage,
                            $ligne->date_emp,
                            $ligne->date_ret,
                            $ligne->penalite
                    );
                    array_push($res, $unPret);
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
     * v�rifie si un pret existe
     * @param   $id : le code du pret � contr�ler
     * @return  un bool�en
     */    
    public static function pretExiste($id) {
        $values = PretDal::loadPretByID($id, 1);
        if (Application::dataOK($values)) {
            return 1;
        }
        return 0;
    }
        
    public static function ajouterPret($valeurs) {
        $id = PretDal::addPret(
            $valeurs[0],
            $valeurs[1],
            $valeurs[2],
            $valeurs[3],
            $valeurs[4]
        );
        return self::chargerPretParID($id);
    }

    public static function modifierPret($pret) {
        return PretDal::setPret(
            $pret->getId(), 
            $pret->getNoClient(),
            $pret->getNoOuvrage(),
            $pret->getDateEmp(),
            $pret->getDateRet(),
            $pret->getPenalite()
        );
    }    
    
    public static function supprimerPret($id) {
        return PretDal::delPret($id);
    }    
    
    /**
     * r�cup�re les caract�ristiques d'un pret
     * @param   $id : le code du pret
     * @return  un objet de la classe pret
     */
    public static function chargerPretParId($id) {
        $values = PretDal::loadGenericPret(1,array($id));
        if (Application::dataOK($values)) {
            $id = $values[0]->id_pret;
            $no_client = $values[0]->no_client;
            $no_ouvrage = $values[0]->no_ouvrage;
            $date_emp = $values[0]->date_emp;
            $date_ret = $values[0]->date_ret;
            $penalite = $values[0]->penalite;
            return new Auteur ($id, $no_client, $no_ouvrage, $date_emp, $date_ret, $penalite);
        }
        return NULL;
    }
    
        
}
