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
 * @author 	pv
 * @version    	1.0
 */

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class OuvrageDal { 
       
    /**
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadOuvrages($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM v_ouvrages';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }

    /**
     * charge un objet de la classe Ouvrage à partir de son code
     * @param  $id : le numéro de l'ouvrage
     * @return  un objet de la classe Ouvrage
    */   
    public static function loadOuvrageByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM v_ouvrages WHERE no_ouvrage = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    /**
     * charge un tableau d'objets de la classe Auteur à partir d'un Ouvrage
     * @param  $no : le numéro de l'ouvrage
     * @return  un objet de la classe Ouvrage
    */   
    public static function loadAuteursByOuvrage($no) {
        $cnx = new PdoDao();
        $qry = 'SELECT id_auteur FROM auteur_ouvrage WHERE no_ouvrage = ?';
        $res = $cnx->getRows($qry,array($no),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    
    /**
     * Ajoute un ouvrage
     * @param type $strTitre
     * @param type $intSalle
     * @param type $strRayon
     * @param type $strGenre
     * @param type $strDate
     * @return type
     */
    public static function addOuvrage(
            $strTitre,
            $intSalle,
            $strRayon,
            $idAuteur,
            $strGenre,
            $strDate
    ) {
        $cnx = new PdoDao();
        // On ajoute ici un ouvrage
        $qry = 'INSERT INTO ouvrage (titre, salle, rayon,code_genre, date_acquisition) VALUES (?,?,?,?,?)';
        $res = $cnx->execSQL($qry,array(
                $strTitre,
                $intSalle,
                $strRayon,
                $strGenre,
                $strDate)
                );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        
        $qry = "SELECT MAX(no_ouvrage) FROM ouvrage";
        $id = $cnx->getValue($qry, array());
        
        // On attribue l'ouvrage à un auteur
        $qry = 'INSERT INTO auteur_ouvrage VALUES(?,?)';
        $rq = $cnx->execSQL($qry, array($id,$idAuteur));
        if (is_a($rq,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        
        return $id;
    }
    
    
    public static function setOuvrage(
            $no,
            $titre,
            $salle,
            $rayon,
            $codeGenre,
            $date
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE ouvrage SET titre = ?,'
                              . ' salle = ?,'
                              . ' rayon = ?,'
                              . ' code_genre = ?,'
                              . ' date_acquisition = ?'
                              . 'WHERE no_ouvrage = ?';
        $res = $cnx->execSQL($qry,array(
                $titre,
                $salle,
                $rayon,
                $codeGenre,
                $date,
                $no
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return 1;
        
    }

    /**
     * supprime un ouvrage
     * @param   int $code : le code de l'ouvrage à supprimer
    */      
    public static function delOuvrage($code) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM ouvrage WHERE no_ouvrage = ?';
        $res = $cnx->execSQL($qry,array($code));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    

    /**
     * calcule le nombre d'ouvrages pour un genre
     * @param   int $code : le code du genre
    */      
    public static function countOuvragesGenre($code) {
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM ouvrage WHERE code_genre = ?';
        $res = $cnx->getValue($qry,array($code));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
}
