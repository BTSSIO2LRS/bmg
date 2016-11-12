<?php
/**
 * Contrôleur secondaire chargé de la gestion des prets
 * @author  pv
 * @package default (mission 4)
 */

// bibliothèques à utiliser
require_once ('modele/App/Application.class.php');
require_once ('modele/App/Notification.class.php');
require_once ('modele/Render/AdminRender.class.php');
require_once ('modele/Bll/Ouvrages.class.php');
require_once ('modele/Bll/Genres.class.php');
require_once ('modele/Bll/Auteurs.class.php');
require_once ('modele/Bll/Prets.class.php');


// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerPrets';
}
// si un id est passé en paramètre, créer un objet (pour consultation, modification ou suppression)
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    $unPret = Prets::chargerPretParId($id);
}

// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'listerPrets' : {
        // récupérer les ouvrages
        $lesPrets = Prets::chargerLesPrets(1);
        // afficher le nombre de ouvrages
        $nbPrets = count($lesPrets);
        include 'vues/v_listePrets.php';
    } break; 
}