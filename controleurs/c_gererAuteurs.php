<?php
/**
 * Contrôleur secondaire chargé de la gestion des auteurs
 * @author  dk, pv
 * @package default (mission 4)
 */

// bibliothèques à utiliser
require_once ('modele/App/Application.class.php');
require_once ('modele/App/Notification.class.php');
require_once ('modele/Render/AdminRender.class.php');
require_once ('modele/Bll/Auteurs.class.php');

// récupération de l'action à effectuer
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $action = 'listerAuteurs';
}


if(isset($_REQUEST["id"]))
{
    $intID = intval(htmlentities($_REQUEST["id"]));
    $lAuteur = Auteurs::chargerAuteurParId($intID); 
}

// variables pour la gestion des messages
$titrePage = 'Gestion des auteurs';

// variables pour la gestion des erreurs
$tabErreurs = array(); 
$hasErrors = false;

// ouvrir une connexion
$cnx = new PdoDao();

// charger la vue en fonction du choix de l'utilisateur
switch ($action) {
    case 'consulterAuteur' : {
        if (isset($_GET["id"])) {
            // récupération des valeurs dans la base
            try {
                if ($lAuteur) {
                    $strNom = $lAuteur->getNom();
                    $strPrenom = $lAuteur->getPrenom();
                    $strAlias = $lAuteur->getAlias();
                    $strNotes = $lAuteur->getNotes();
                }
                else {
                    $tabErreurs["Erreur"] = "Cet auteur n'existe pas !";
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
		"Aucun auteur n'a été transmis pour consultation !";
            $hasErrors = true;
        }
        if ($hasErrors) {
            $msg = "Une erreur s'est produite :";
            include 'vues/v_afficherErreurs.php';
        }
        else {
            include 'vues/v_consulterAuteur.php';
        }
    } break;
    case 'ajouterAuteur' : {
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
            $option = 'saisirAuteur';
        }
        switch($option) {            
            case 'saisirAuteur' : {
                include 'vues/v_ajouterAuteur.php';
            } break;
            case 'validerAuteur' : {
                // tests de gestion du formulaire
                if (isset($_POST["cmdValider"])) {
                    // récupération des valeurs saisies
                    if (!empty($_POST["txtNom"])) {
                        $strNom = ucfirst($_POST["txtNom"]);
                    }
                    if (!empty($_POST["txtPrenom"])) {
                        $strPrenom = ucfirst($_POST["txtPrenom"]);
                    }
                    if (!empty($_POST["txtAlias"])) {
                        $strAlias = ucfirst($_POST["txtAlias"]);
                    }
                    if (!empty($_POST["txtNotes"])) {
                        $strNotes = ucfirst($_POST["txtNotes"]);
                    }                        
                    // test zones obligatoires 
                    if (!empty($strNom)) {
                        // les zones obligatoires sont présentes
                    }
                    else {
                        if (empty($strNom)) {
                            $tabErreurs["Nom"] = "Le nom doit être renseigné !";
                        }
                        $hasErrors = true;
                    }                    
                    if (!$hasErrors) {
                        // ajout dans la base de données
                        try {
                            $res = Auteurs::ajouterAuteur(array(
                                    $strNom,$strPrenom,$strAlias,$strNotes
                                )
                            );
                            if ($res) {
                                $msg = '<span class="info">L\'auteur '
                                    .$strNom.' '
                                    .$strPrenom.' a été ajouté</span>';
                                // récupération du numéro (auto-incrément)
                                $strSQL = "SELECT MAX(id_auteur) FROM auteur";
                                $intID = $cnx->getValue( $strSQL, array());
                                include 'vues/v_consulterAuteur.php';
                            }
                            else {
                                $tabErreurs["Erreur"] = "Une erreur s'est produite 
                                    dans l'opération d'ajout !";
                                $tabErreurs["Nom"] = $strNom;
                                $tabErreurs["Prenom"] = $strPrenom;
                                $tabErreurs["Alias"] = $strAlias;
                                $tabErreurs["Notes"] = $strNotes;
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
                        $lien = '<a href="index.php?uc=gererAuteurs&action=ajouterAuteur">Retour à la saisie</a>';
                        include 'vues/v_afficherErreurs.php';
                        }
                    }
            } break;
        }
    } break;
    case 'modifierAuteur' : {
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
            $option = 'saisirAuteur';
        }
        switch($option) {            
            case 'saisirAuteur' : {
                // récupération du code
                if (isset($_GET["id"])) {
                    
                    if (count($lAuteur) == 1) {
                        $strNom = $lAuteur->getNom();
                        $strPrenom = $lAuteur->getPrenom();
                        $strAlias = $lAuteur->getAlias();
                        $strNotes = $lAuteur->getNotes();
                    }
                    else {
                        $tabErreurs["Erreur"] = "Cet auteur n'existe pas !";
                        $tabErreurs["ID"] = $intID;
                        $hasErrors = true;
                    }
                }
                include 'vues/v_modifierAuteur.php';
            } break;
            case 'validerAuteur' : {
                // si on a cliqué sur Valider
                if (isset($_POST["cmdValider"])) {
                    // mémoriser les données pour les réafficher dans le formulaire
                    $intID = intval($_POST["txtID"]);
                    // récupération des valeurs saisies
                    if (!empty($_POST["txtNom"])) {
                        $strNom = ucfirst($_POST["txtNom"]);
                    }
                    if (!empty($_POST["txtPrenom"])) {
                        $strPrenom = ucfirst(($_POST["txtPrenom"]));
                    }
                    if (!empty($_POST["txtAlias"])) {
                        $strAlias = ucfirst(($_POST["txtAlias"]));
                    }
                    if (!empty($_POST["txtNotes"])) {
                        $strNotes = ucfirst($_POST["txtNotes"]);
                    }                            
                    // test zones obligatoires
                    if (!empty($strNom)) {
                        // les zones obligatoires sont présentes
                        // tests de cohérence
                    }
                    else {
                        if (empty($strNom)) {
                            $tabErreurs["Nom"] = "Le nom doit être renseigné !";
                        }
                        $hasErrors = true;
                    }
                    if (!$hasErrors) {
                        // mise à jour dans la base de données
                        try {
                            $res = Auteurs::modifierAuteur(
                                    new Auteur(
                                    $intID,
                                    $strNom,
                                    $strPrenom,
                                    $strAlias,
                                    $strNotes
                                    ));
                            if ($res) {                                    
                                $msg = '<span class="info">L\'auteur '
                                    .$strNom.' '
                                    .$strPrenom.' a été modifié</span>';
                                include 'vues/v_consulterAuteur.php';
                            }
                            else {
                                $tabErreurs["Erreur"] = 'Une erreur s\'est produite lors de l\'opération de mise à jour !';
                                $tabErreurs["ID"] = $intID;
                                $tabErreurs["Nom"] = $strNom;
                                $tabErreurs["Prenom"] = $strPrenom;
                                $tabErreurs["Alias"] = $strAlias;
                                $tabErreurs["Notes"] = $strNotes;
                                // en phase de test, on peut ajouter le SQL :
                                $tabErreurs["SQL"] = $res;
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
                    $tabErreurs["Erreur"] = "Aucun auteur n'a été transmis pour modification !";
                    $hasErrors = true;
                }
            }
        }       
        // affichage des erreurs
        if ($hasErrors) {
            $msg = "Une erreur s'est produite :";
            include 'vues/v_afficherErreurs.php';
            include 'vues/v_modifierAuteur.php';
        }
    } break;
    case 'supprimerAuteur' : {
        // récupération de l'identifiant du auteur passé dans l'URL
        if (isset($_GET["id"])) {
                       
            if (count($lAuteur) == 1) {
                $strNom = $lAuteur->getNom();
                $strPrenom = $lAuteur->getPrenom();
                $strAlias = $lAuteur->getAlias();
            }
            else {
                $tabErreurs["Erreur"] = "Cet auteur n'existe pas !";
                $tabErreurs["Code"] = $intID;
                $hasErrors = true;
            }
            if (!$hasErrors) {
                // rechercher des ouvrages de ce auteur
                try {
                    $ouvragesAuteur = Auteurs::nbOuvragesParAuteurs($intID);
                    if ($ouvragesAuteur == 0) {
                        // c'est bon, on peut le supprimer
                        try {
                            $res = Auteurs::supprimerAuteur($intID);
                            if ($res) {
                                $msg = 'L\'auteur '
                                    .$strNom.' a été supprimé';
                                Application::addNotification(new Notification($msg, SUCCESS));
                                $lesAuteurs = Auteurs::chargerLesAuteurs(1);
                                $nbAuteurs = count($lesAuteurs);
                                include 'vues/v_listeAuteurs.php';
                                }                                                    
                            }
                        catch (PDOException $e) {
                            $tabErreurs["Erreur"] = 
                                    "Une exception PDO a été levée !";
                            $tabErreurs["Message"] = $e->getMessage();
                            $hasErrors = true;
                        }
                    }
                    else {
                        $tabErreurs["Erreur"] = "Cet auteur est référencé par des ouvrages, suppression impossible !";
                        $tabErreurs["ID"] = $intID;
                        $tabErreurs["Nom"] = $strNom;
                        $tabErreurs["Prénom"] = $strPrenom;
                        $tabErreurs["Ouvrages"] = $ouvragesAuteur;
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
            $lien = '<a href="index.php?uc=gererAuteurs&action=consulterAuteur&id=' 
                        .$intID.'">Retour à la consultation</a>';
            include 'vues/v_afficherErreurs.php';            
        }
    } break;   
    case 'listerAuteurs' : {
        // récupérer les auteurs
        $lesAuteurs = Auteurs::chargerLesAuteurs(1);
        // afficher le nombre de auteurs
        $nbAuteurs = count($lesAuteurs);
        include 'vues/v_listeAuteurs.php';
    } break;
    
}

// TODO déconnexion //