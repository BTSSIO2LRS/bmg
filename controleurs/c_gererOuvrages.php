<?php
/**
 * Contrôleur secondaire chargé de la gestion des ouvrages
 * @author  dk
 * @package default (mission 4)
 */

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerOuvrages';
}

// variables pour la gestion des messages
$titrePage = 'Gestion des ouvrages';

// variables pour la gestion des erreurs
$tabErreurs = array(); 
$hasErrors = false;

// ouvrir une connexion
$cnx = connectDB();

// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'consulterOuvrage' : {
        if (isset($_GET["id"])) {
            $intID = intval(htmlentities($_GET["id"]));
            // récupération des valeurs dans la base
            $strSQL = "SELECT no_ouvrage as ID, "
                    ."titre, "
                    ."acquisition, "
                    ."lib_genre, "
                    ."salle, "
                    ."rayon, "
                    ."dernier_pret, "
                    ."disponibilite, "
                    ."auteur "
                    ."FROM v_ouvrages "
                    ."WHERE no_ouvrage = ".$intID;
            try {
                $lOuvrage = getRows($cnx, $strSQL, array($intID));
                if ($lOuvrage) {
                    $strTitre = $lOuvrage[0][1];
                    $strAcquisition = $lOuvrage[0][2];
                    $strGenre = $lOuvrage[0][3];
                    $strSalle = $lOuvrage[0][4];
                    $strRayon = $lOuvrage[0][5];
                    $strDernierPret = $lOuvrage[0][6];
                    $strDispo = $lOuvrage[0][7];
                    $strAuteur = $lOuvrage[0][8];
                }
                else {
                    $tabErreurs["Erreur"] = "Cet ouvrage n'existe pas !";
                    $tabErreurs["ID"] = $intID;
                    $hasErrors = true;
                }                
            }
            catch (PDOException $e) {
                $tabErreurs["Erreur"] = $e->getMessage();
                $hasErrors = true;
            }
        }
        else {
            // pas d'id dans l'url ni clic sur Valider : c'est anormal
            $tabErreurs["Erreur"] = 
		"Aucun ouvrage n'a été transmis pour consultation !";
            $hasErrors = true;
        }
        if ($hasErrors) {
            $msg = "Une erreur s'est produite :";
            include 'vues/v_afficherErreurs.php';
        }
        else {
            include 'vues/v_consulterOuvrage.php';
        }
    } break;
    case 'ajouterOuvrage' : {
        // initialisation des variables
        $strTitre = '';
        $intSalle = 1;
        $strRayon = '';
        $strGenre = '';
        $strDate = '';
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        }
        else {
            $option = 'saisirOuvrage';
        }
        switch($option) {            
            case 'saisirOuvrage' : {
                $strSQL = "SELECT code_genre, lib_genre FROM genre";
                $lesGenres = getRows($cnx, $strSQL, array());                
                include 'vues/v_ajouterOuvrage.php';
            } break;
            case 'validerOuvrage' : {
                // tests de gestion du formulaire
                if (isset($_POST["cmdValider"])) {
                    // récupération des valeurs saisies
                    if (!empty($_POST["txtTitre"])) {
                        $strTitre = ucfirst($_POST["txtTitre"]);
                    }
                    $intSalle = $_POST["rbnSalle"];
                    if (!empty($_POST["txtRayon"])) {
                        $strRayon = ucfirst($_POST["txtRayon"]);
                    }
                    $strGenre = $_POST["cbxGenres"];
                    if (!empty($_POST["txtRayon"])) {
                        $strDate = $_POST["txtDate"];
                    }
                    // test zones obligatoires
                    if (!empty($strTitre) and 
                            !empty($strRayon) and
                            !empty($strDate)) {
                        // tests de cohérence
                        // test de la date d'acquisition
                        $dateAcquisition = new DateTime($strDate);
                        $curDate = new DateTime(date('Y-m-d'));
                        if ($dateAcquisition > $curDate) {
                            // la date d'acquisition est postérieure à la date du jour
                            $tabErreurs["Erreur date"] = "La date d'acquisition doit être antérieure ou égale à la date du jour";
                            $tabErreurs["Date"] = $strDate;
                            $hasErrors = true;
                        }
                        // contrôle du rayon
                        if (!rayonValide($strRayon)) {
                            $tabErreurs["Erreur rayon"] = "Le rayon n'est pas valide, il doit comporter une lettre et un chiffre !";
                            $tabErreurs["Rayon"] = $strRayon;
                            $hasErrors = true;
                        }
                    }
                    else {
                        if (empty($strTitre)) {
                            $tabErreurs["Titre"] = "Le titre doit être renseigné !";
                        }
                        if (empty($strRayon)) {
                            $tabErreurs["Rayon"] = "Le rayon doit être renseigné !";
                        }
                        if (empty($strDate)) {
                            $tabErreurs["Acqisition"] = "La date d'acquisition doit être renseignée !";
                        }
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        // ajout dans la base de données
                            $strSQL = "INSERT INTO ouvrage (titre, salle, rayon, code_genre, date_acquisition) "
                                    . "VALUES (?,?,?,?,?)";
                        try {
                            $res = execSQL(
                                $cnx, $strSQL, array(
                                    $strTitre,
                                    $intSalle,
                                    $strRayon,
                                    $strGenre,
                                    $strDate
                                )
                            );
                            if ($res) {
                                $msg = '<span class="info">L\'ouvrage '
                                    .$strTitre.' a été ajouté</span>';
                                // récupération du numéro (auto-incrément)
                                $strSQL = "SELECT MAX(no_ouvrage) FROM ouvrage";
                                $intID = getValue($cnx, $strSQL, array());
                                // récupération des valeurs dans la base
                                $strSQL = "SELECT no_ouvrage as ID, "
                                        ."titre, "
                                        ."acquisition, "
                                        ."lib_genre, "
                                        ."salle, "
                                        ."rayon, "
                                        ."dernier_pret, "
                                        ."disponibilite, "
                                        ."auteur "
                                        ."FROM v_ouvrages "
                                        ."WHERE no_ouvrage = ".$intID;
                                $lOuvrage = getRows($cnx, $strSQL, array($intID));
                                if ($lOuvrage) {
                                    $strTitre = $lOuvrage[0][1];
                                    $strAcquisition = $lOuvrage[0][2];
                                    $strGenre = $lOuvrage[0][3];
                                    $strSalle = $lOuvrage[0][4];
                                    $strRayon = $lOuvrage[0][5];
                                    $strDernierPret = $lOuvrage[0][6];
                                    $strDispo = $lOuvrage[0][7];
                                    $strAuteur = $lOuvrage[0][8];
                                }
                                else {
                                    $msg = "Cet ouvrage n'existe pas !";
                                }
                                include 'vues/v_consulterOuvrage.php';
                            }
                            else {
                                $tabErreurs["Erreur"] = "Une erreur s'est produite 
                                    dans l'opération d'ajout !";
                                $tabErreurs["Titre"] = $strTitre;
                                $tabErreurs["Salle"] = $intSalle;
                                $tabErreurs["Rayon"] = $strRayon;
                                $tabErreurs["Genre"] = $strGenre;
                                $tabErreurs["Acquisition"] = $strDate;
                                $hasErrors = true;
                            }
                        }
                        catch (PDOException $e) {
                            $tabErreurs["Erreur"] = 
                                    "Une exception PDO a été levée !";
                            $hasErrors = true;
                        }
                    }
                    else {
                        $msg = "L'opération d'ajout n'a pas pu être menée 
                            à terme en raison des erreurs suivantes :";
                        $lien = '<a href="index.php?uc=gererOuvrages&action=ajouterOuvrage">Retour à la saisie</a>';
                        include 'vues/v_afficherErreurs.php';
                        }
                    }
            } break;
        }        
    } break;    
    case 'modifierOuvrage' : {
        // initialisation des variables
        $strNom = '';
        $strPrenom = '';
        $strAlias = '';
        $strNotes = '';        
        // traitement de l'option : saisie ou validation ?
        if (isset($_GET["option"])) {
            $option = htmlentities($_GET["option"]);
        }
        else {
            $option = 'saisirOuvrage';
        }
        switch($option) {            
            case 'saisirOuvrage' : {
                // récupération du code
                if (isset($_GET["id"])) {
                    $intID = intval(htmlentities($_GET["id"]));
                    // récupération des données dans la base
                    $strSQL = "SELECT titre, salle, rayon, code_genre, date_acquisition "
                        ."FROM ouvrage "
                        ."WHERE no_ouvrage = ".$intID;
                    $lOuvrage = getRows($cnx, $strSQL, array($intID));
                    if (count($lOuvrage) == 1) {
                        $strTitre = $lOuvrage[0][0];
                        $intSalle = $lOuvrage[0][1];
                        $strRayon = $lOuvrage[0][2];
                        $strGenre = $lOuvrage[0][3];
                        $strDate = $lOuvrage[0][4];                    }
                    else {
                        $tabErreurs["Erreur"] = "Cet ouvrage n'existe pas !";
                        $tabErreurs["ID"] = $intID;
                        $hasErrors = true;
                    }
                }
                include 'vues/v_modifierOuvrage.php';
            } break;
            case 'validerOuvrage' : {
                // si on a cliqué sur Valider
                if (isset($_POST["cmdValider"])) {
                    // mémoriser les données pour les réafficher dans le formulaire
                    $intID = intval($_POST["txtID"]);
                    // récupération des valeurs saisies
                    if (!empty($_POST["txtTitre"])) {
                        $strTitre = ucfirst($_POST["txtTitre"]);
                    }
                    $intSalle = $_POST["rbnSalle"];
                    if (!empty($_POST["txtRayon"])) {
                        $strRayon = ucfirst($_POST["txtRayon"]);
                    }
                    $strGenre = $_POST["cbxGenres"];
                    if (!empty($_POST["txtRayon"])) {
                        $strDate = $_POST["txtDate"];
                    }
                    // test zones obligatoires
                    if (!empty($strTitre) and 
                            !empty($strRayon) and
                            !empty($strDate)) {
                        // tests de cohérence
                        // test de la date d'acquisition
                        $dateAcquisition = new DateTime($strDate);
                        $curDate = new DateTime(date('Y-m-d'));
                        if ($dateAcquisition > $curDate) {
                            // la date d'acquisition est postérieure à la date du jour
                            $tabErreurs["Erreur date"] = 'La date d\'acquisition doit être antérieure ou égale à la date du jour';
                            $tabErreurs["Date"] = $strDate;
                            $hasErrors = true;
                        }
                        // contrôle du rayon
                        if (!rayonValide($strRayon)) {
                            $tabErreurs["Erreur rayon"] = 'Le rayon n\'est pas valide, il doit comporter une lettre et un chiffre !';
                            $tabErreurs["Rayon"] = $strRayon;
                            $hasErrors = true;
                        }
                    }
                    else {
                        if (empty($strTitre)) {
                            $tabErreurs["Titre"] = "Le titre doit être renseigné !";
                        }
                        if (empty($strRayon)) {
                            $tabErreurs["Rayon"] = "Le rayon doit être renseigné !";
                        }
                        if (empty($strDate)) {
                            $tabErreurs["Acqisition"] = "La date d'acquisition doit être renseignée !";
                        }
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        // mise à jour dans la base de données
                        $strSQL = "UPDATE ouvrage SET titre = ?,"
                                ."salle = ?,"
                                ."rayon = ?,"
                                ."code_genre = ?,"
                                ."date_acquisition = ? "
                                ."WHERE no_ouvrage = ?";
                        try {
                            $res = execSQL($cnx, $strSQL, array(
                                    $strTitre,
                                    $intSalle,
                                    $strRayon,
                                    $strGenre,
                                    $strDate,
                                    $intID
                                )
                            );
                            if ($res) {
                                $msg = '<span class="info">L\'ouvrage '
                                    .$strTitre.' a été modifié</span>';
                                // récupération des valeurs dans la base
                                $strSQL = "SELECT no_ouvrage as ID, "
                                        ."titre, "
                                        ."acquisition, "
                                        ."lib_genre, "
                                        ."salle, "
                                        ."rayon, "
                                        ."dernier_pret, "
                                        ."disponibilite, "
                                        ."auteur "
                                        ."FROM v_ouvrages "
                                        ."WHERE no_ouvrage = ".$intID;
                                $lOuvrage = getRows($cnx, $strSQL, array($intID));
                                if ($lOuvrage) {
                                    $strTitre = $lOuvrage[0][1];
                                    $strAcquisition = $lOuvrage[0][2];
                                    $strGenre = $lOuvrage[0][3];
                                    $strSalle = $lOuvrage[0][4];
                                    $strRayon = $lOuvrage[0][5];
                                    $strDernierPret = $lOuvrage[0][6];
                                    $strDispo = $lOuvrage[0][7];
                                    $strAuteur = $lOuvrage[0][8];
                                }
                                else {
                                    $msg = "Cet ouvrage n'existe pas !";
                                }
                                include 'vues/v_consulterOuvrage.php';
                            }
                            else {
                                $tabErreurs["Erreur"] = 'Une erreur s\'est produite lors de l\'opération de mise à jour !';
                                $tabErreurs["ID"] = $intID;
                                $tabErreurs["Titre"] = $strTitre;
                                $tabErreurs["Salle"] = $intSalle;
                                $tabErreurs["Rayon"] = $strRayon;
                                $tabErreurs["Genre"] = $strGenre;
                                $tabErreurs["Date"] = $strDate;
                                // en phase de test, on peut ajouter le SQL :
                                $tabErreurs["SQL"] = $strSQL;
                                $hasErrors = true;
                            }
                        }
                        catch (PDOException $e) {
                            $tabErreurs["Erreur"] = 'Une exception a été levée !';
                            $hasErrors = true;
                        }
                    }
                }
                else {
                    // pas d'id dans l'url ni clic sur Valider : c'est anormal
                    $tabErreurs["Erreur"] = "Aucun ouvrage n'a été transmis pour modification !";
                    $hasErrors = true;
                }
            }
        }       
        // affichage des erreurs
        if ($hasErrors) {
            $msg = "Une erreur s'est produite :";
            include 'vues/v_afficherErreurs.php';
            include 'vues/v_modifierOuvrage.php';
        }
    } break;
    case 'supprimerOuvrage' : {
        // récupération de l'identifiant du ouvrage passé dans l'URL
        if (isset($_GET["id"])) {
            $intID = intval(htmlentities($_GET["id"]));
            // récupération des données  dans la base
            $strSQL = "SELECT nom_ouvrage, prenom_ouvrage, alias "
                ."FROM ouvrage "
                ."WHERE id_ouvrage = ?";
            $lOuvrage = getRows($cnx, $strSQL, array($intID));            
            if (count($lOuvrage) == 1) {
                $strNom = $lOuvrage[0][0];
                $strPrenom = $lOuvrage[0][1];
                $strAlias = $lOuvrage[0][2];
            }
            else {
                $tabErreurs["Erreur"] = "Cet ouvrage n'existe pas !";
                $tabErreurs["Code"] = $intID;
                $hasErrors = true;
            }
            if (!$hasErrors) {
                // rechercher des prêts de cet ouvrage
                $strSQL = "SELECT COUNT(*)  "
                    ."FROM pret "
                    ."WHERE no_ouvrage = ?";
                try {
                    $prets = getValue($cnx, $strSQL, array($intID));
                    if ($prets == 0) {
                        // c'est bon, on peut le supprimer
                        $strSQL = "DELETE FROM ouvrage WHERE no_ouvrage = ?";
                        try {
                            $res = execSQL($cnx, $strSQL, array($intID));
                            if ($res) {
                                $msg = '<span class="info">L\'ouvrage '
                                    .$strNom.' a été supprimé';
                                include 'vues/v_afficherMessage.php';
                        }                                                    }
                        catch (PDOException $e) {
                            $tabErreurs["Erreur"] = 
                                    "Une exception PDO a été levée !";
                            $tabErreurs["Message"] = $e->getMessage();
                            $hasErrors = true;
                        }
                    }
                    else {
                        $tabErreurs["Erreur"] = "Cet ouvrage est référencé par des prêts, suppression impossible !";
                        $hasErrors = true;
                    }
                }
                catch (PDOException $e) {
                     $tabErreurs["Erreur"] = $e->getMessage();
                }
            }
        }
        // affichage des erreurs
        if ($hasErrors) {
            $msg = "Une erreur s'est produite :";
            $lien = '<a href="index.php?uc=gererOuvrages&action=consulterOuvrage&id=' 
                        .$intID.'">Retour à la consultation</a>';
            include 'vues/v_afficherErreurs.php';            
        }
    } break;   
    case 'listerOuvrages' : {
        // récupérer les ouvrages
        $strSQL = "SELECT no_ouvrage as ID, "
                ."titre, "
                ."lib_genre, "
                ."auteur, "
                ."salle, "
                ."rayon, "
                ."dernier_pret, "
                ."disponibilite "
                ."FROM v_ouvrages "
                ."ORDER BY titre;";
        $lesOuvrages = getRows($cnx, $strSQL, array());
        // afficher le nombre de ouvrages
        $nbOuvrages = count($lesOuvrages);
        include 'vues/v_listeOuvrages.php';
    } break; 
}
// déconnexion
disconnectDB($cnx);
