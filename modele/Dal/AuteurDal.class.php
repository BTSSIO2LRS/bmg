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

class AuteurDal { 
       
    /**
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadAuteurs($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM auteur';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }

    /**
     * charge un objet de la classe Auteur à partir de son id
     * @param  $id : l'identifiant de l'auteur
     * @return  un objet de la classe Auteur
    */   
    public static function loadAuteurById($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM auteur WHERE id_auteur = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    /**
     * Ajoute une auteur
     * @param string $strNom le nom de l'auteur
     * @param string $strPrenom le prénom de l'auteur
     * @param string $strAlias l'alias de l'auteur
     * @param string $strNotes les notes de l'auteur
     * @return int $id l'id de l'auteur
     */ 
    public static function addAuteur(
            $strNom,
            $strPrenom,
            $strAlias,
            $strNotes
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO auteur (nom_auteur, prenom_auteur, alias, notes) VALUES (?,?,?,?)';
        $res = $cnx->execSQL($qry,array(
                $strNom,
                $strPrenom,
                $strAlias,
                $strNotes)
                );
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        else{
            $strSQL = "SELECT MAX(id_auteur) FROM auteur";
            $id = $cnx->getValue( $strSQL, array());
            if (is_a($id,'PDOException')) {
                return PDO_EXCEPTION_VALUE;
            }
            else{
               return $id;
            }
        }
    }
    
    /**
     * Modifie un auteur
     * @param type $intID
     * @param string $strNom le nom de l'auteur
     * @param string $strPrenom le prénom de l'auteur
     * @param string $strAlias l'alias de l'auteur
     * @param string $strNotes les notes de l'auteur
     * @return int $id l'id de l'auteur
     */
    public static function setAuteur(
            $intID,
            $strNom,
            $strPrenom,
            $strAlias,
            $strNotes
    ) {
        $cnx = new PdoDao();
            $qry = 'UPDATE auteur SET nom_auteur = ?,'
                                  . ' prenom_auteur = ?,'
                                  . ' alias = ?,'
                                  . ' notes = ?'
                                  . 'WHERE id_auteur = ?';
            $res = $cnx->execSQL($qry,array(
                    $strNom,
                    $strPrenom,
                    $strAlias,
                    $strNotes,
                    $intID
                ));
            if (is_a($res,'PDOException')) {
                return PDO_EXCEPTION_VALUE;
            }
            return $res;
        
    }

    /**
     * supprime un auteur
     * @param   int $int : l'id de l'auteur à supprimer
    */      
    public static function delAuteur($int) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM auteur WHERE id_auteur = ?';
        $res = $cnx->execSQL($qry,array($int));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    

    /**
     * calcule le nombre d'ouvrages pour un auteur
     * @param   int $id : l'id de l'auteur
    */      
    public static function countOuvragesAuteur($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM auteur_ouvrage WHERE id_auteur = ?';
        $res = $cnx->getValue($qry,array($id));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }
    
    /**
     * loadAuteursOuvrage charge tous les auteurs sauf ceux contenu dans le tableaux $tabException
     * @param type $style : 0 == tableau associatif , 1 == "objet"
     * @param tableau d'objets $tabException le tableau contenant les auteurs devant être évité lors du chargement des auteurs
     * @return type un tableau associatif ou "objet"
     */
      public static function loadAuteursNotInOuvrage($style, $tabException) {
        $cnx = new PdoDao();
        if(empty($tabException)){
            $qry = 'SELECT id_auteur, nom_auteur AS nom ,prenom_auteur, alias AS prenom FROM auteur';
        }
        else{
            $qry = 'SELECT id_auteur, nom_auteur AS nom, prenom_auteur AS prenom, alias FROM auteur WHERE id_auteur
            NOT IN (
                SELECT id_auteur FROM auteur WHERE ';
                foreach($tabException as $ligne){
                     $id = $ligne->getId();
                     $qry .= ' id_auteur = '.$id.' OR';
                }
                $qry .= ' id_auteur = ""';
            $qry .= ') ORDER BY nom_auteur';
        }
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }
    
}
