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
 * @author 	dk
 * @version    	1.0
 */

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class GenreDal { 
       
    /**
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadGenres($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM genre';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }

    /**
     * charge un objet de la classe Genre à partir de son code
     * @param  $id : le code du genre
     * @return  un objet de la classe Genre
    */   
    public static function loadGenreByID($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM genre WHERE code_genre = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    /**
     * ajoute un genre
     * @param   string  $code : le code du genre à ajouter
     * @param   string  $libelle : le libellé du genre à ajouter
     * @return  object un objet de la classe Genre
    */      
    public static function addGenre(
            $code,
            $libelle
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO genre VALUES (?,?)';
        $res = $cnx->execSQL($qry,array(
                $code,
                $libelle
            )
        );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $code;
    }
    
    /**
     * modifie un genre
     * @param   int     $code
     * @param   string  $libelle
     * @return  un code erreur
    */      
    public static function setGenre(
            $code,
            $libelle
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE genre SET lib_genre = ? WHERE code_genre = ?';
        $res = $cnx->execSQL($qry,array(
                $libelle,
                $code
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * supprime un genre
     * @param   int $code : le code du genre à supprimer
    */      
    public static function delGenre($code) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM genre WHERE code_genre = ?';
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
