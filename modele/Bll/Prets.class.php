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
 * @author 	    Bapt Alicia T2 28/09/2016
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Prets : fabrique d'objets Pret
 *  ====================================================================
 */

// sollicite les méthodes de la classe PretDal
require_once ('./modele/Dal/PretDal.class.php');
// sollicite les services de la classe Application
require_once ('./modele/App/Application.class.php');
// sollicite la référence
require_once ('./modele/Reference/Pret.class.php');

class Prets {

    /**
     * Méthodes publiques
     */
    
    /**
     * récupère les prets
     * @param   $mode : 0 == tableau assoc, 1 == tableau d'objets
     * @return  un tableau de type $mode 
     */    
    public static function chargerLesPrets($mode) {
        $tab = PretDal::loadPrets(1);
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
        
}