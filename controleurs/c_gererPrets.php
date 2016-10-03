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
    $action = 'listerOuvrages';
}
// si un id est passé en paramètre, créer un objet (pour consultation, modification ou suppression)
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    $unPret = Prets::chargerPretParId($id);
}

// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'listerOuvrages' : {
        // récupérer les ouvrages
        $lesPrets = Prets::chargerLesPrets(1);
        // afficher le nombre de ouvrages
        $nbPrets = count($lesPrets);
        include 'vues/v_listePrets.php';
    } break;    
    case 'consulterOuvrage' : {
        if ($unPret == NULL) {
            Application::addNotification(new Notification("Cet ouvrage n'existe pas !", ERROR));
            $lesOuvrages = Ouvrages::chargerLesOuvrages(0);
            // afficher le nombre de ouvrages
            $nbOuvrages = count($lesOuvrages);
            include 'vues/v_listeOuvrages.php';
        }
        else {
            $no = $unOuvrage->getNo();
            $strTitre = $unOuvrage->getTitre();
            $strAuteur = $unOuvrage->getAuteurs();
            $strAcquisition = $unOuvrage->getDateAcqui();
            $strGenre = $unOuvrage->getGenre()->getLibelle();
            $strSalle = $unOuvrage->getSalle();
            $strRayon = $unOuvrage->getRayon();
            $strDernierPret = $unOuvrage->getDernierPret();
            $strDispo = $unOuvrage->getDispo();
            include 'vues/v_consulterOuvrage.php';
        }
    } break;
    case 'ajouterOuvrage' : {
        // initialisation des variables
        $hasErrors = false;
        $strTitre = '';
        $intSalle = 1;        
        $strRayon = '';
        $strDate =  '';
        $rq = Genres::chargerLesGenres(0);
        $lesGenres = array();
        foreach($rq as $values)
        {
            $lesGenres[$values->code_genre] = $values->lib_genre;
        }
        $strGenre = $rq[1]->code_genre;
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        }
        else {
            $option = 'saisirOuvrage';
        }
        switch($option) {            
            case 'saisirOuvrage' : {
                include 'vues/v_ajouterOuvrage.php';
            } break;
            case 'validerOuvrage' : {
                // tests de gestion du formulaire
                if (isset($_POST["cmdValider"])) {
                    // test zones obligatoires
                    if (!empty($_POST["txtTitre"]) and
                        !empty($_POST["rbnSalle"]) and
                        !empty($_POST["txtRayon"]) and
                        !empty($_POST["cbxGenres"])and
                        !empty($_POST["txtDate"])) {
                        // les zones obligatoires sont présentes
                        $strTitre = htmlspecialchars($_POST["txtTitre"]);
                        
                        if(preg_match("#^[0-2]$#", $intSalle))
                        {
                            $intSalle = htmlspecialchars($_POST["rbnSalle"]);
                        }
                        else{
                            $hasErrors = true;
                        }
                        
                        if(rayonValide($_POST['txtRayon']))
                        {
                            $strRayon = htmlspecialchars($_POST['txtRayon']);
                        }
                        else{
                            $hasErrors = true;
                        }
                        
                        if(Genres::genreExiste($_POST["cbxGenres"]))
                        {
                            $strGenre = $_POST["cbxGenres"];
                        }
                        else{
                            $hasErrors = true;
                        }
                        
                        if(strtotime($_POST["txtDate"]) <= strtotime(date('Y-m-d')))
                        {
                            $strDate = $_POST["txtDate"];
                        }
                        else{
                            $hasErrors = true;
                        }
                    }
                    else {
                        // une ou plusieurs valeurs n'ont pas été saisies
                        if (empty($_POST["txtTitre"])) {                                
                            Application::addNotification(new Notification("Le titre doit être renseigné !", ERROR));
                        }
                        if (empty($_POST["rbnSalle"])) {
                            Application::addNotification(new Notification("La salle doit être renseigné !", ERROR));
                        }
                        if (empty($_POST["txtRayon"])) {
                            Application::addNotification(new Notification("Le rayon doit être renseigné !", ERROR));
                        }
                        if (empty($_POST["cbxGenres"])) {
                            Application::addNotification(new Notification("Le genre doit être renseigné !", ERROR));
                        }
                        if(empty($_POST["txtDate"])){
                            Application::addNotification(new Notification("La date doit être renseigné !", ERROR));
                        }
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        // ajout dans la base de données
                        $unOuvrage = Ouvrages::ajouterOuvrage(array($strTitre,$intSalle,$strRayon,$strGenre,$strDate));
                            
                        Application::addNotification(new Notification("L'ouvrage à été ajouté !", SUCCESS));
                        
                        $no = $unOuvrage->getNo();
                        $strTitre = $unOuvrage->getTitre();
                        $strAuteur = $unOuvrage->getAuteurs();
                        $strAcquisition = $unOuvrage->getDateAcqui();
                        $strGenre = $unOuvrage->getGenre()->getLibelle();
                        $strSalle = $unOuvrage->getSalle();
                        $strRayon = $unOuvrage->getRayon();
                        $strDernierPret = $unOuvrage->getDernierPret();
                        $strDispo = $unOuvrage->getDispo();
                        include 'vues/v_consulterOuvrage.php';
                    }
                    else {
                        if(!preg_match("#^([0-2])$#", $_POST["rbnSalle"]))
                        {
                            Application::addNotification(new Notification("La salle doit être 1 ou 2 !", ERROR));
                        }
                        
                        if(!empty($_POST["txtRayon"]) && !rayonValide($_POST["txtRayon"]))
                        {
                            Application::addNotification(new Notification("Le rayon doit être au format suivant : 1 lettre majuscule et 1 chiffre !", ERROR));
                        }
                        
                        if(!empty($_POST["cbxGenres"]) && !Genres::genreExiste($_POST["cbxGenres"]))
                        {
                            Application::addNotification(new Notification("Le genre :".$_POST["cbxGenres"]." séléctionné n'existe pas !", ERROR));
                        }
                        
                        if(!empty($_POST["txtDate"]) && (strtotime($_POST["txtDate"]) > strtotime(date('Y-m-d'))))
                        {
                            Application::addNotification(new Notification("La date doit être inférieur à ".date('Y-m-d')." !", ERROR));
                        }
                        include 'vues/v_ajouterOuvrage.php';
                    }
                }
            } break;
        }        
    } break;    
    case 'modifierOuvrage' : {
        // initialisation des variables
        $hasErrors = false;
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        }
        else {
            $option = 'saisirOuvrage';
        }
        switch($option) {            
            case 'saisirOuvrage' : {
                // récupération de l'id
                if (isset($_GET["id"]) && $unOuvrage) {
                    
                    //initialisation des données
                    $no = $unOuvrage->getNo();
                    $strTitre = $unOuvrage->getTitre();
                    $strAcquisition = $unOuvrage->getDateAcqui();
                    $strGenre = $unOuvrage->getGenre()->getCode();
                    $intSalle = $unOuvrage->getSalle();
                    $strRayon = $unOuvrage->getRayon();
                    $strDernierPret = $unOuvrage->getDernierPret();
                    $strDispo = $unOuvrage->getDispo();
                    
                    //Création d'un tableau de genre afin de formater celui-ci en vue de l'utiliser en paramét
                    $lesGenres = Genres::chargerLesGenres(0);
                    $lesGenres = array();
                    foreach($rq as $values)
                    {
                        $lesGenres[$values->code_genre] = $values->lib_genre;
                    }
                    
                    include("vues/v_modifierOuvrage.php");
                }
                else {
                    Application::addNotification(new Notification("L'ouvrage est inconnu !", ERROR));
                    $lesOuvrages = Ouvrages::chargerLesOuvrages(0);
                    // afficher le nombre de ouvrages
                    $nbOuvrages = count($lesOuvrages);
                    include("vues/v_listeOuvrages.php");
                }
            } break;
            case 'validerOuvrage' : {
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