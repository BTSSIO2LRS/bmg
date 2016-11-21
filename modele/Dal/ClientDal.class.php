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
 * @author 		collectif
 * @version    	1.0
 */

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class ClientDal { 
       
    /**
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
    */   
    public static function loadClient($style) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM client';
        $res = $cnx->getRows($qry,array(),$style);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }        
        return $res;
    }

    /**
     * charge un objet de la classe Auteur à partir de son id
     * @param  int	$id : l'identifiant de l'auteur
     * @return  un objet de la classe Auteur
    */   
    public static function loadClientById($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT * FROM client WHERE no_client = ?';
        $res = $cnx->getRows($qry,array($id),1);
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    
    /**
     * ajoute un client
     * @param   string  $nom : le nom de l'auteur
     * @param   string  $prenom : le prénom de l'auteur à ajouter
	 * @param   string  $alias : l'alias de l'auteur à ajouter
	 * @param   string  $notes : les notes relatives l'auteur à ajouter
     * @return  object un objet de la classe Auteur
    */      
    public static function addClient(
            $caution,
            $caution_encaissee,
            $code_post,
            $date_inscription,
            $etat,
            $login,
            $mel,
            $montant,
            $nom,
            $passe,
            $prenom,
            $rue,
            $ville
    ) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO client(caution, caution_encaisse, code_post, date_inscr,'
                . 'etat_client, login, mel, montant_compt, nom_client, password, prenom,'
                . 'rue_client, ville) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $cnx->execSQL($qry,array(
            $caution,
            $caution_encaissee,
            $code_post,
            $date_inscription,
            $etat,
            $login,
            $mel,
            $montant,
            $nom,
            $passe,
            $prenom,
            $rue,
            $ville
            )
        );
        $qry = 'SELECT MAX(no_client) FROM client';
        $id = $cnx->getValue($qry, array());
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $id;
    }
    
    /**
     * modifie un auteur
     * @param   int     $id
     * @param   string  $nom
	 * @param   string  $prenom
	 * @param   string  $alias
	 * @param   string  $notes
     * @return  un code erreur
    */      
    public static function setClient(
            $caution,
            $caution_encaissee,
            $code_post,
            $date_inscription,
            $etat,
            $login,
            $mel,
            $montant,
            $nom,
            $passe,
            $prenom,
            $rue,
            $ville
    ) {
        $cnx = new PdoDao();
        $qry = 'UPDATE auteur SET caution = ?, caution_encaisse = ?, code_post = ?, date_inscr = ?,'
                . 'etat_client = ?, login = ?, mel = ?, montant_compt = ?, nom_client = ?, password = ?, prenom = ?,'
                . 'rue_client = ?, ville = ?'
                . 'WHERE id_auteur = ?';
        $res = $cnx->execSQL($qry,array(
                $caution,
            $caution_encaissee,
            $code_post,
            $date_inscription,
            $etat,
            $login,
            $mel,
            $montant,
            $nom,
            $passe,
            $prenom,
            $rue,
            $ville
            ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }

    /**
     * supprime un auteur
     * @param   int $id : l'id de l'auteur à supprimer
    */      
    public static function delClient($id) {
        $cnx = new PdoDao();
        $qry = 'DELETE FROM client WHERE no_client = ?';
        $res = $cnx->execSQL($qry,array($id));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }    
    /**
     * compte le nombre d'ouvrages d'un auteur
     * @param   int $id : l'id de l'auteur
     
    
    public static function countOuvragesAuteur($id) {
        $cnx = new PdoDao();
        $qry = 'SELECT COUNT(*) FROM auteur_ouvrage WHERE id_auteur = ?';
        $res = $cnx->getValue($qry,array($id));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }*/

}


