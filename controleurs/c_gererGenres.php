<?php
/**
 * Contrôleur secondaire chargé de la gestion des genres
 * @author  dk
 * @package default (mission 4)
 */

// bibliothèques à utiliser
require_once ('modele/App/Application.class.php');
require_once ('modele/App/Notification.class.php');
require_once ('modele/Render/AdminRender.class.php');
require_once ('modele/Bll/Genres.class.php');

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerGenres';
}
// si un id est passé en paramètre, créer un objet (pour consultation, modification ou suppression)
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    $unGenre = Genres::chargerGenreParID($id);
}

// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'listerGenres' : {
        // récupérer les genres
        $lesGenres = Genres::chargerLesGenres(1);
        // afficher le nombre de genres
        $nbGenres = count($lesGenres);
        include 'vues/v_listeGenres.php';
    } break;    
    case 'consulterGenre' : {
        if ($unGenre == NULL) {
            Application::addNotification(new Notification("Ce genre n'existe pas !", ERROR));
        }
        else {
            include 'vues/v_consulterGenre.php';
        }
    } break;
    case 'ajouterGenre' : {
        // initialisation des variables
        $hasErrors = false;
        $strCode = '';
        $strLibelle = '';
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        }
        else {
            $option = 'saisirGenre';
        }
        switch($option) {            
            case 'saisirGenre' : {
                include 'vues/v_ajouterGenre.php';
            } break;
            case 'validerGenre' : {
                // tests de gestion du formulaire
                if (isset($_POST["cmdValider"])) {
                    // test zones obligatoires
                    if (!empty($_POST["txtCode"]) and !empty($_POST["txtLibelle"])) {
                        // les zones obligatoires sont présentes
                        $strLibelle = ucfirst(htmlentities(
                                $_POST["txtLibelle"])
                        );
                        $strCode = strtoupper(htmlentities(
                                $_POST["txtCode"])
                        );
                        // tests de cohérence 
                        // contrôle d'existence d'un genre avec le même code
                        if (Genres::genreExiste($strCode)) {
                            // signaler l'erreur
                            Application::addNotification(new Notification("Il existe déjà un genre avec ce code !", ERROR));
                            $hasErrors = true;
                        }
                    }
                    else {
                        // une ou plusieurs valeurs n'ont pas été saisies
                        if (empty($strCode)) {                                
                            Application::addNotification(new Notification("Le code doit être renseigné !", ERROR));
                        }
                        if (empty($strLibelle)) {
                            Application::addNotification(new Notification("Le libellé doit être renseigné !", ERROR));
                        }
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        // ajout dans la base de données
                        $unGenre = Genres::ajouterGenre(array($strCode,$strLibelle));
                        Application::addNotification(new Notification("Le genre a été ajouté !", SUCCESS));
                        include 'vues/v_consulterGenre.php';
                    }
                    else {
                        include 'vues/v_ajouterGenre.php';
                    }
                }
            } break;
        }        
    } break;    
    case 'modifierGenre' : {
        // initialisation des variables
        $hasErrors = false;
        $strLibelle = '';
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        }
        else {
            $option = 'saisirGenre';
        }
        switch($option) {            
            case 'saisirGenre' : {
                // récupération du code
                if (isset($_GET["id"])) {
                    include("vues/v_modifierGenre.php");
                } 
                else {
                    Application::addNotification(new Notification("Le genre est inconnu !", ERROR));
                    include("vues/v_listeGenres.php");
                }
            } break;
            case 'validerGenre' : {
                // si on a cliqué sur Valider
                if (isset($_POST["cmdValider"])) {
                    // mémoriser les valeurs pour les réafficher 
                    // test zones obligatoires
                    if (!empty($_POST["txtLibelle"])) {
                        // les zones obligatoires sont présentes
                        $strLibelle = ucfirst(htmlentities($_POST["txtLibelle"]));
                        // tests de cohérence
                    }
                    else {
                        if (empty($strLibelle)) {
                            Application::addNotification(new Notification("Le libellé est obligatoire !", ERROR));
                        }
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        // mise à jour dans la base de données
                        $unGenre->setLibelle($strLibelle);
                        $res = Genres::modifierGenre($unGenre);
                        Application::addNotification(new Notification("Le genre a été modifié !", SUCCESS));
                        include 'vues/v_consulterGenre.php';
                    }
                    else {
                        include("vues/v_modifierGenre.php");
                    }
                }
            }
        }
    } break;
    case 'supprimerGenre' : {
        // rechercher des ouvrages de ce genre
        if (Genres::nbOuvragesParGenre($unGenre->getCode()) > 0) {
            // il y a des ouvrages référencés, suppression impossible
            Application::addNotification(new Notification("Il existe des ouvrages qui référencent ce genre, suppression impossible !", ERROR));
            include 'vues/v_consulterGenre.php';
        }
        else {
            // supprimer le genre
            Genres::supprimerGenre($unGenre->getCode());
            Application::addNotification(new Notification("Le genre a été supprimé !", SUCCESS));
            // afficher la liste
            $lesGenres = Genres::chargerLesGenres(1);
            $nbGenres = count($lesGenres);
            include 'vues/v_listeGenres.php';            
        }
    } break;   
}

