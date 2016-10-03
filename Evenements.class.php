<?php

/**
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * Business Logic Layer
 *
 * Utilise les services des classes de la bibliothèque Reference
 * Utilise les services de la classe EvenementDal
 * Utilise les services de la classe Application
 *
 * @package 	default
 * @author 	CARDOSO FONSECA Pierre
 * @version    	1.0
 */


/*
 *  ====================================================================
 *  Classe Evenements : fabrique d'objets Evenement
 *  ====================================================================
 */

// sollicite les méthodes de la classe EvenementDal
require_once ('./modele/Dal/EvenementDal.class.php');
// sollicite les services de la classe Application
require_once ('./modele/App/Application.class.php');
// sollicite la référence
require_once ('./modele/Reference/Evenement.class.php');

class Evenements 
{
    /**
     * Méthodes publiques
     */
    
    /**
     * Récupère les évènements des clients
     * @param int $mode 0 == tableau assoc, 1 == tableau d'objets
     * @return tableau un tableau de type $mode
     */
    public static function chargerLesEvenements($mode)
    {
        $tab = EvenementDal::loadEvenements(1);
        if(Application::dataOK($tab))
        {
            if($mode == 1)
            {
                $res = array();
                 foreach ($tab as $ligne) {
                    $unEvenement = new Evenement(
                            $ligne->id_evenement, 
                            $ligne->no_client,
                            $ligne->date_evenement,
                            $ligne->type_evenement,
                            $ligne->id_pret,
                            $ligne->desc_evenement
                    );
                    array_push($res, $unEvenement);
                 }
                 return $res;
            }
            else
            {
                return $tab;
            }
        }
        return NULL;
    }
    
    /**
     * Récupère le nombre d'évènement pour un client
     * @param int $no_client le code du client
     * @return int 
     */
    public static function nbEvenementsParClient($no_client)
    {
        return EvenementDal::countEvenementsClient($no_client);
    }
}

