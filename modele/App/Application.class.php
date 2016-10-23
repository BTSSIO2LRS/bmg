<?php
/** 
 * BMG
 * © GroSoft, 2016
 * 
 * Application
 * Classe technique pour l'application
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */

/*
 *  ====================================================================
 *  Classe Application : fournit des services génériques
 *  ====================================================================
*/

class Application {
      
    /**
     * Méthodes publiques
    */				

    /**********************************************
    * Accès aux données
    ***********************************************/
    
    /**
     * Vérifie si un getRows() ou un getValue() retourne quelque chose
     * @param   $value : un tableau ou une valeur quelconque
     * @return  bool 
     */    
    public static function dataOK($value) {
        return ($value != NULL) && ($value != PDO_EXCEPTION_VALUE);
    }    

    /**********************************************
    * Gestion des notifications
    ***********************************************/
    
    /**
     * Ajoute une notification dans le tableau des notifications
     * @param  $notification : un objet de la classe Notification
     */
    public static function addNotification($notification) {
        if (!isset($_SESSION['notifications'])) {
            $_SESSION['notifications'] = array();
        } 
        $_SESSION['notifications'][] = $notification;
    }

    /**
     * Retourne le nombre de lignes du tableau des notifications 
     * @return le nombre de notifications
     */
    public static function nbNotifications() {
        if (!isset($_SESSION['notifications'])) {
            return 0;
        }
        else {
            return count($_SESSION['notifications']);
        }
    }

    public static function resetNotifications() {
        unset($_SESSION['notifications']);
    }

}

