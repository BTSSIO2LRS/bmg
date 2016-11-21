<?php

/**
 * BMG
 * © GroSoft, 2015
 * 
 * Data Access Layer
 * Classe d'accès aux données 
 *
 * Utilise les services de la classe PdoDao
 *
 * @package 	default
 * @author 	Andriolo & Collin , 28/09/2016
 * @version    	1.0
 */
// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class PretDal {

    /**
     * @author PV
     * loadGenericPret est une fonction générique permettant de charger des prêts
     * @param int $mode 0 => charge tous les prêts de tous les clients avec etat optionel, 1 => charge un 
     * prêts par id, 2 => charge tous les prêts d'un clients par etat
     * @param array $arrayParams si mode 0 donné un état de prêts (voir config.inc.php), si mode 1 mettre
     * un id de pret dans le tableau, si mode 2 mettre un numéro de client et un état de prêts (voir config.inc.php)
     * @return mixed 
     *               => si les paramétres de la fonction ne concorde pas avec le mode utilisé, la fonctions retournera false
     *               => si l'exécution se déroule normalement la fonction retourne le résultat de l'appel à la procédure stockée< 
     */
    public static function loadGenericPret($mode, $arrayParams) {

        $cnx = new PdoDao();

        $id = null;
        $etat = null;

        switch ($mode) {
            case 0: {
                    if (count($arrayParams) == 1) {
                        $etat = $arrayParams[0];
                    }
                }break;
            case 1: {
                    if (count($arrayParams) == 1) {
                        $id = $arrayParams[0];
                    } else {
                        return false;
                    }
                }break;
            case 2: {
                    if (count($arrayParams) == 2) {
                        $id = $arrayParams[0];
                        $etat = $arrayParams[1];
                    } elseif (count($arrayParams) == 1) {
                        $id = $arrayParams[0];
                    } else {
                        return false;
                    }
                }break;
        }
        $qry = 'CALL sp_load_prets(?,?,?)';
        $res = $cnx->getRows($qry, array($mode, $id, $etat), 1);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * @author PV
     * @param int $no_client le numéro du cient emprunteur
     * @param int $no_ouvrage le numéro de l'ouvrage emprunté
     * @param date $date_emp la date d'emprunt de l'ouvrage
     * @return Pret un objet de la classe Pret
     */
    public static function addPret($no_client, $no_ouvrage, $date_emp) {
        $cnx = new PdoDao();
        // Appel à la procédure stocké //
        $qry = 'CALL sp_add_pret(?,?,?,@p_erreur)';
        // Exécution de la requête //
        $res = $cnx->execSQL($qry, array($no_client, $no_ouvrage, $date_emp));
        if (is_a($res, 'PDOException')) {
            // Si la requête à échoué //
            return PDO_EXCEPTION_VALUE;
        }
        // La requête n'à pas échoué //
        // Récupération de l'erreur //
        $result = $cnx->getValue("SELECT @p_erreur", array());
        return $result;
    }

}
