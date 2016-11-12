<?php

/** 
 * 
 * BMG
 * © GroSoft, 2016
 * 
 * Classe technique
 * Fournit des méthodes statiques permettant l'affichage de parties génériques
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */

class AdminRender {

    /**
     * Constantes
    */				
    
    // icones et messages d'erreur
    const MSG_SUCCESS = 'b-alert-success f-alert-success';
    const MSG_WARNING = 'b-alert-warning f-alert-warning';
    const MSG_INFO = 'b-alert-info f-alert-info';
    const MSG_ERROR = 'b-alert-error f-alert-error';
    const MSG_QUESTION = 'b-alert-question f-alert-question';
    const ICON_SUCCESS = 'fa fa-check-circle-o';
    const ICON_WARNING = 'fa fa-exclamation-circle';
    const ICON_INFO = 'fa fa-info-circle';
    const ICON_QUESTION = 'fa fa-question-circle';
    const ICON_ERROR = 'fa fa-exclamation-triangle';    
    
    /*
     * composant d'affichage d'un message d'erreur
     * @param  $message : le message à afficher
     * @param  $boxStyle : style de massage, voir constantes MSG_
     * @param  $inconStyle : icone, voir contrantes ICON_
    */
    static function showMessage($message,$boxStyle,$iconStyle) {
        $component = '';
        $component .= '<div class="';
        $component .= $boxStyle.'">';
        $component .= '<div class="b-remaining">';
        $component .= '<i class="';
        $component .= $iconStyle;
        $component .= '"></i> ';
        $component .= $message;
        $component .= '</div></div>';
        return $component;
    }    

    public static function showNotifications() {
        if (Application::nbNotifications() > 0) {
            foreach ($_SESSION['notifications'] as $notification) {
                switch($notification->getType()) {
                    case INFO : { 
                        $typeMsg = self::MSG_INFO; 
                        $icon = self::ICON_INFO;
                    } break;
                    case ERROR : { 
                        $typeMsg = self::MSG_ERROR; 
                        $icon = self::ICON_ERROR;
                    } break;
                    case SUCCESS : { 
                        $typeMsg = self::MSG_SUCCESS; 
                        $icon = self::ICON_SUCCESS;
                    } break;
                    case WARNING : { 
                        $typeMsg = self::MSG_WARNING; 
                        $icon = self::ICON_WARNING;
                    } break;
                }
                echo self::showMessage($notification->getMsg(),$typeMsg,$icon);
            }
            Application::resetNotifications();
        }
    }    
    
    /**
     * Affiche une liste de choix à partir d'un jeu de résultat 
     * de la forme {identifiant, libellé}
     * @param string $tab : un tableau de deux colonnes
     * @param string $classe : la classe CSS à appliquer à l'élément
     * @param string $id : l'id (et nom) de la liste de choix
     * @param int $size : l'attribut size de la liste de choix
     * @param string $idSelect : l'élément à présélectionner dans la liste
     * @param string $onchange : le nom de la fonction à appeler 
     * en cas d'événement onchange()
    */
    public static function displayList ($tab, $classe, $id, $size, $idSelect, $onchange) {
        // affichage de la liste de choix
        echo '<select class="'.$classe.'" id="'.$id.'" name="'.$id.'" id="'.$id.'" size="'
                .$size.'" onchange="'.$onchange . '">';
        if (count($tab) && (empty($idSelect))) {
            $idSelect = $tab[0][0];
        }
        foreach ($tab as $ligne) {
            // l'élément en paramètre est présélectionné
            if ($ligne[0] != $idSelect) {
                echo '<option value="'.$ligne[0].'">'.$ligne[1].'</option>';
            } 
            else {
                echo '<option selected value="'.$ligne[0].'">'.$ligne[1].'</option>';
            }
        }
        echo '</select>';
        return $idSelect;
    }
    
    /**
     * Retourne une balise img
     * @param   string  $dir : le nom du dossier
     * @param   int     $id : le numéro de la photo
     * @param   string  $class : le nom d'une classe CSS
     * @param   int     $maxWidth : largeur max de l'image
     * @param   int     $maxHeight : hauteur max de l'image
     * @return string
    */
    public static function getImage($dir, $id, $class) {
        $img = '<img class="'.$class.'" src="';
        $imgName = $dir.$id.'.jpg';
        if (file_exists($imgName)) {
            $img .= $imgName.'" alt=""';
        }
        else {
            $img .= NOT_FOUND_IMG.'" alt="Image indisponible"';
        }
        $img .= ' />';
        return $img;
    }    
    
}