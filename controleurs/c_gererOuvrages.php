<?php
/**
 * Contrôleur secondaire chargé de la gestion des ouvrages
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

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerOuvrages';
}
// si un id est passé en paramètre, créer un objet (pour consultation, modification ou suppression)
if (isset($_REQUEST["id"]) && !empty($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    $unOuvrage = Ouvrages::chargerOuvrageParID($id);
}

// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'listerOuvrages' : {
        // récupérer les ouvrages
        $lesOuvrages = Ouvrages::chargerLesOuvrages(0);
        // afficher le nombre de ouvrages
        $nbOuvrages = count($lesOuvrages);
        include 'vues/v_listeOuvrages.php';
    } break;    
    case 'consulterOuvrage' : {
        if (!isset($unOuvrage)) {
            Application::addNotification(new Notification("Cet ouvrage n'existe pas !", ERROR));
            $lesOuvrages = Ouvrages::chargerLesOuvrages(0);
            // afficher le nombre de ouvrages
            $nbOuvrages = count($lesOuvrages);
            include 'vues/v_listeOuvrages.php';
        }
        else {
            initDisplayOuvrage($unOuvrage,"vues/v_consulterOuvrage.php");
        }
    } break;
    case 'ajouterOuvrage' : {
        
        // initialisation des variables
        $hasErrors = false;
        $strTitre = '';
        $intSalle = 1;        
        $strRayon = '';
        $strDate =  '';
        
        // On charge les genres pour les lister afin de pouvoir sélectionner le genre de l'ouvrage
        $chargeLesGenres = Genres::chargerLesGenres(1);
        $lesGenres = array();
        foreach($chargeLesGenres as $values)
        {
            $lesGenres[$values->getCode()] = $values->getLibelle();
        }
        $strGenre = Utilities::firstOccur($lesGenres, 1);
        
        // On charge les auteurs pour les lister afin de pouvoir sélectionner l'auteur de l'ouvrage
        $chargeLesAuteurs = Auteurs::chargerLesAuteurs(1);
        $lesAuteurs = array();
        foreach($chargeLesAuteurs as $values)
        {
            $lesAuteurs[$values->getId()] = $values->decrireAuteur();
        }
        $strAuteur = Utilities::firstOccur($lesAuteurs, 1);
        
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
                    $data = testDataOuvrage($_POST);
                    if (is_array($data)) {
                        // ajout dans la base de données
                        $unOuvrage = Ouvrages::ajouterOuvrage(array($data["titre"], $data["salle"], $data["rayon"], $data["auteur"], $data["genre"], $data["date"]));
                        Application::addNotification(new Notification("L'ouvrage à été ajouté !", SUCCESS));
                        initDisplayOuvrage($unOuvrage, 'vues/v_consulterOuvrage.php');
                    }
                    else {
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
                // récupération des données après vérification de la présence de l'objet ouvrage
                if (isset($unOuvrage) ) {
                    initDisplayOuvrage($unOuvrage,"vues/v_modifierOuvrage.php");
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
                    // On test l'existence et la cohérence des valeurs
                    $dataOuvrage = testDataOuvrage($_POST);
                    if (is_array($dataOuvrage)) {
                        // mise à jour dans la base de données
                        if(isset($_SESSION["no_ouvrage"]) and !empty($_SESSION["no_ouvrage"]))
                        {
                            $unOuvrage = Ouvrages::chargerOuvrageParId($_SESSION["no_ouvrage"]);
                        }
                        $unOuvrage->setTitre($dataOuvrage["titre"]);
                        $unOuvrage->setSalle($dataOuvrage["salle"]);
                        $unOuvrage->setRayon($dataOuvrage["rayon"]);
                        $genre = Genres::chargerGenreParId($dataOuvrage["genre"]);
                        $unOuvrage->setGenre($genre->getCode(), $genre->getLibelle());
                        $unOuvrage->setDateAcqui($dataOuvrage["date"]);
                        
                        $res = Ouvrages::modifierOuvrage($unOuvrage);
                        if($res == 1)
                        {
                            Application::addNotification(new Notification("L'ouvrage a été modifié !", SUCCESS));
                        }
                        else{
                            Application::addNotification(new Notification("Malheureusement la modification de l'ouvrage à échoué !", ERROR));
                        }
                        initDisplayOuvrage($unOuvrage, 'vues/v_consulterOuvrage.php');
                    }
                    else {
                        initDisplayOuvrage($unOuvrage, "vues/v_modifierOuvrage.php");
                    }
                }
            }
        }
    } break;
    case 'supprimerOuvrage' : {
        
        if (isset($unOuvrage) ) {
           // supprimer l'ouvrage
            
            if(Ouvrages::supprimerOuvrage($unOuvrage->getNo()))
            {
                Application::addNotification(new Notification("L'ouvrage a été supprimé !", SUCCESS));
                // afficher la liste
                $lesOuvrages = Ouvrages::chargerLesOuvrages(0);
                $nbOuvrages = count($lesOuvrages);
                include 'vues/v_listeOuvrages.php';
            }
            else {
               // la requête à retourner une PDO_EXCEPTION
               Application::addNotification(new Notification("La requéte à malheureusement échoué", ERROR));
               $unOuvrage = Ouvrages::chargerOuvrageParID($unOuvrage->getNo());
               include 'vues/v_consulterOuvrage.php';
            }
        }
        else {
            // l'ouvrage n'existe pas
            Application::addNotification(new Notification("La requéte à malheureusement échoué", ERROR));
            $unOuvrage = Ouvrages::chargerOuvrageParID($unOuvrage->getNo());
            include 'vues/v_consulterOuvrage.php';
        }
    } break;   
}

/**
 * initDisplayOuvrage initialise les données d'un objet ouvrage donnée en paramétre et
 * les affiche dans la vue dont le chemin est donnée en paramétre
 * @param Ouvrage $unOuvrage un objet de la classe ouvrage
 * @param string $include un chemin pointant vers une vue à laquelle on transmet les données pour l'affichage
 */
function initDisplayOuvrage($unOuvrage,$include)
{
    //initialisation des données
    $no = $unOuvrage->getNo();
    $strTitre = $unOuvrage->getTitre();
    $intSalle = $unOuvrage->getSalle();
    $strRayon = $unOuvrage->getRayon();
    $strAcquisition = $unOuvrage->getDateAcqui();
    $strCodeGenre = $unOuvrage->getGenre()->getCode();
    $strLibGenre = $unOuvrage->getGenre()->getLibelle();
    $strDernierPret = $unOuvrage->getDernierPret();
    $strDispo = $unOuvrage->getDispo();
    $strAuteur = $unOuvrage->affichAuteursThisOuvrage(1);
    //Création d'un tableau de genre afin de formater celui-ci en vue de l'utiliser en paramét
    $rq = Genres::chargerLesGenres(0);
    $lesGenres = array();
    foreach($rq as $values)
    {
        $lesGenres[$values->code_genre] = $values->lib_genre;
    }
    include($include);
}

/**
 * testDataOuvrage test les valeurs saisis pour la création d'un ouvrage 
 * et les renvoies dans un tableau si celle-ci sont correct, si elles sont
 * incorect, ont ajoute des notifications et ont renvoie false
 * @param array $data un tableau de données
 */
function testDataOuvrage($data)
{
    $dataOuvrage = array();
    if (!empty($data["txtTitre"]) and
        !empty($data["rbnSalle"]) and
        !empty($data["txtRayon"]) and
        !empty($data["cbxAuteurs"])and
        !empty($data["cbxGenres"])and
        !empty($data["txtDate"])) {
        // les zones obligatoires sont présentes
        $dataOuvrage["titre"] = htmlspecialchars($data["txtTitre"]);

        if(preg_match("#^[0-2]$#", $data["rbnSalle"]))
        {
            $dataOuvrage["salle"] = htmlspecialchars($data["rbnSalle"]);
        }
        else
        {
            Application::addNotification(new Notification("La salle doit être 1 ou 2 !", ERROR));
        }

        if(rayonValide($data['txtRayon']))
        {
            $dataOuvrage["rayon"] = htmlspecialchars($data['txtRayon']);
        }
        else
        {
            Application::addNotification(new Notification("Le rayon doit être au format suivant : 1 lettre majuscule et 1 chiffre !", ERROR));
        }

        if(Genres::genreExiste($data["cbxGenres"]))
        {
            $dataOuvrage["genre"] = $data["cbxGenres"];
        }
        else
        {
            Application::addNotification(new Notification("Le genre :".$_POST["cbxGenres"]." séléctionné n'existe pas !", ERROR));
        } 
        
        if(Auteurs::AuteurExiste($data["cbxAuteurs"]))
        {
            $dataOuvrage["auteur"] = $data["cbxAuteurs"];
        }
        else
        {
            Application::addNotification(new Notification("L'auteur :".$_POST["cbxAuteurs"]." séléctionné n'existe pas !", ERROR));
        } 

        if(strtotime($data["txtDate"]) <= strtotime(date('Y-m-d')))
        {
            $dataOuvrage["date"] = $data["txtDate"];
        }
        else
        {
            Application::addNotification(new Notification("La date doit être inférieur à ".date('Y-m-d')." !", ERROR));
        }   
    }
    else {
        // une ou plusieurs valeurs n'ont pas été saisies
        if (empty($data["txtTitre"])) {                                
            Application::addNotification(new Notification("Le titre doit être renseigné !", ERROR));
        }
        if (empty($data["rbnSalle"])) {
            Application::addNotification(new Notification("La salle doit être renseigné !", ERROR));
        }
        if (empty($data["txtRayon"])) {
            Application::addNotification(new Notification("Le rayon doit être renseigné !", ERROR));
        }
        if (empty($data["cbxGenres"])) {
            Application::addNotification(new Notification("Le genre doit être renseigné !", ERROR));
        } 
        if (empty($data["cbxAuteurs"])) {
            Application::addNotification(new Notification("Le'auteur doit être renseigné !", ERROR));
        }
        if(empty($data["txtDate"])){
            Application::addNotification(new Notification("La date doit être renseigné !", ERROR));
        }
    }
    if(count($dataOuvrage)==6)
    {
        return $dataOuvrage;
    }
    else{
        return false;
    }
}