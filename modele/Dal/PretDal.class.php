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
     * loadGenericPret est une fonction générique permettant de charger de prêts
     * @param int $mode 0 => charge tous les prêts de tous les clients avec etat optionel, 1 => charge un 
     * prêts par id, 2 => charge tous les prêts d'un clients par etat
     * @param array $arrayParams si mode 0 donné un état de prêts (voir config.inc.php), si mode 1 mettre
     * un id de pret dans le tableau, si mode 2 mettre un numéro de client et un état de prêts (voir config.inc.php)
     * @return le résultat d'une requête 
     */
    public static function loadGenericPret($mode,$arrayParams) {
        
        $cnx = new PdoDao();
        
        $id = null;
        $etat = null;
        
        switch($mode)
        {
            case 0:{
                if(count($arrayParams)==1)
                {
                    $etat = $arrayParams[0];
                }
            }break;
            case 1:{
                if(count($arrayParams)==1)
                {
                    $id = $arrayParams[0];
                }
                else{
                    return false;
                }
            }break;
            case 2:{
                if(count($arrayParams)==2)
                {
                    $id = $arrayParams[0];
                    $etat = $arrayParams[1];
                }
                elseif(count($arrayParams)==1)
                {
                    $id = $arrayParams[0];
                }
                else{
                    return false;
                }
            }break;
        }
        $qry = 'CALL sp_load_prets(?,?,?)';
        $res = $cnx->getRows($qry, array($mode,$id,$etat), 1);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
}
