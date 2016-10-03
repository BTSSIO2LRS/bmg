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
 * @author 	CARDOSO FONSECA Pierre
 * @version    	1.0
 */

//Solicitte les services de la classe PdoDao
require_once ('PdoDao.class.php');

class EvenementDal
{
    /**
     * @param $style : 0 == tableau assoc, 1 == objet
     * @return un objet de la classe PDOStatement
     */
    public static function loadEvenements($style)
    {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM evenement';
        $res = $cnx->getRows($qry, array(), $style);
        if(is_a($res, 'PDOException'))
        {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * charge un objet de la classe Evenement à partir de son id
     * @param  $name int $id : l'id de l'évènement
     * @return un objet de la classe évènement
     */
    public static function loadEvenementByID($id)
    {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM evenement WHERE id_evenement = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    
    /**
     * Ajout d'un évènement
     */
    public static function addEvenement();
    
    /**
     * Calcul le nombre d'évènements pour un client
     * @param int $no_client : le code du client
     */
    public static function countEvenementsClient($no_client)
    {
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM evenement WHERE no_client = ?';
        $res = $cnx->getValue($qry,array($no_client));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
}

