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
// sollicite les méthodes de la classe Ouvrages
require_once ('./modele/Bll/Ouvrages.class.php');
// sollicite les méthodes de la classe Clients
require_once ('./modele/Bll/Clients.class.php');

class Prets {
    /**
     * Méthodes publiques
     */

    /**
     * @author PV
     * récupére les prets
     * @param   $mode : 0 == tableau assoc, 1 == tableau d'objets
     *          $etat_pret : voir config.inc.php rubrique "constantes pour la fonction loadGenericPret"
     * @return  un tableau de type $mode 
     */
    public static function chargerLesPrets($mode, $etat_pret) {
        $tab = PretDal::loadGenericPret(0, array($etat_pret));
        if (Application::dataOK($tab)) {
            if ($mode == 1) {
                $res = array();
                foreach ($tab as $ligne) {
                    $unPret = new Pret(
                            $ligne->id_pret, Clients::chargerClientParId($ligne->no_client), Ouvrages::chargerOuvrageParId($ligne->no_ouvrage), $ligne->date_emp, $ligne->date_ret, $ligne->penalite
                    );
                    array_push($res, $unPret);
                }
                return $res;
            } else {
                return $tab;
            }
        }
        return NULL;
    }

    /**
     * vérifie si un pret existe
     * @param   $id : le code du pret é contréler
     * @return  un booléen
     */
    public static function pretExiste($id) {
        $values = PretDal::loadPretByID($id, 1);
        if (Application::dataOK($values)) {
            return 1;
        }
        return 0;
    }

    /**
     * @author PV
     * @param int $no_client le numéro du cient emprunteur
     * @param int $no_ouvrage le numéro de l'ouvrage emprunté
     * @param date $date_emp la date d'emprunt de l'ouvrage
     * @return int $result  0 => l'ajout à été normalement effectué
     *                     -1 => aucun numéro de client n'à été transmis à la procédure
     *                     -2 => le client n'existe pas
     *                     -4 => aucun numéro d'ouvrage n'à été transmis à la procédure
     *                     -6 => l'ouvrage n'existe pas
     *                     -8 => aucune date d'emprunt transmise à la procédure
     *                     -10 => l'ouvrage que l'on souhaite emprunté est déjà prêté
     *                     -99 => La requête à échoué
     */
    public static function ajouterPret($no_client, $no_ouvrage, $date_emp) {
        if (!OuvrageDal::isLendOuvrage($no_ouvrage,false)) {
            $result = PretDal::addPret($no_client, $no_ouvrage, $date_emp);
        }
        else{
            $result = -10;
        }
        return $result;
    }

    public static function modifierPret($pret) {
        return PretDal::setPret(
                        $pret->getId(), $pret->getNoClient(), $pret->getNoOuvrage(), $pret->getDateEmp(), $pret->getDateRet(), $pret->getPenalite()
        );
    }

    public static function supprimerPret($id) {
        return PretDal::delPret($id);
    }

    /**
     * récupére les caractéristiques d'un pret
     * @param   $id : le code du pret
     * @return  un objet de la classe pret
     */
    public static function chargerPretParId($id) {
        $values = PretDal::loadGenericPret(1, array($id));
        if (Application::dataOK($values)) {
            $id = $values[0]->id_pret;
            $client = Clients::chargerClientParId($values[0]->no_client);
            $ouvrage = Ouvrages::chargerOuvrageParId($values[0]->no_ouvrage);
            $date_emp = $values[0]->date_emp;
            $date_ret = $values[0]->date_ret;
            $penalite = $values[0]->penalite;
            return new Pret($id, $client, $ouvrage, $date_emp, $date_ret, $penalite);
        }
        return NULL;
    }

}
