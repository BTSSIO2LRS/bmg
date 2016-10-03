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
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */ 
    public static function loadPrets($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM pret';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }
    /**
     * charge un objet de la classe Pret à partir de son id
     * @param  int	$id : l'identifiant du pret
     * @return  un objet de la classe Pret
    */   
    public static function loadPretById($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM pret WHERE id_pret = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }  
}
